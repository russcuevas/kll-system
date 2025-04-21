<?php
include 'database/connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chatbot Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Floating Chat Button */
        .chat-toggle {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        /* Exclamation mark */
        .exclamation {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background-color: red;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 30px;
            display: none;
            /* Initially hidden */
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }

        /* Chat Container */
        .chat-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.5s ease-in-out, visibility 0s 0.5s;
        }

        .chat-container.show {
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease-in-out;
        }

        .chatbox-wrapper {
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            height: 500px;
        }

        .chatbox {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .chat-header {
            padding: 10px 15px;
            background: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px 15px;
        }

        .chat-buttons {
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #f1f1f1;
            text-align: center;
        }

        .chat-message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
        }

        .chat-message.bot {
            background-color: #e0f7fa;
        }

        .chat-message.user {
            background-color: #e8f5e9;
            text-align: right;
        }
    </style>
</head>

<body>

    <!-- Floating Chat Button -->
    <div id="chat-toggle" class="chat-toggle">🤖</div>

    <!-- Exclamation Sign -->
    <div id="exclamation" class="exclamation">!</div>

    <!-- Chatbox Container -->
    <div id="chat-container" class="chat-container">
        <div class="chatbox-wrapper">
            <div class="chatbox">
                <div class="chat-header d-flex justify-content-between align-items-center">
                    <strong>KLL-Bot</strong>
                    <div>
                        <button id="chat-reset" class="btn btn-sm btn-secondary mr-1">Reset</button>
                        <button id="chat-close" class="btn btn-sm btn-danger">×</button>
                    </div>
                </div>
                <div id="chat-messages" class="chat-messages">
                    <div class="chat-message bot">👋 Hello! How can I help you?</div>
                </div>
                <div id="chat-questions" class="chat-buttons"></div>
            </div>
        </div>
    </div>

    <!-- Chat Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentSequence = 1;
            let groupedQuestions = {};

            const toggleBtn = document.getElementById('chat-toggle');
            const exclamation = document.getElementById('exclamation');
            const chatContainer = document.getElementById('chat-container');
            const closeBtn = document.getElementById('chat-close');
            const resetBtn = document.getElementById('chat-reset');
            const messagesContainer = document.getElementById('chat-messages');
            const questionsContainer = document.getElementById('chat-questions');

            // Show the chat container with a delay
            setTimeout(() => {
                chatContainer.classList.add('show'); // Add the 'show' class to make the chat visible
            }, 3000); // Wait 3 seconds before showing the chat

            // Show Exclamation mark if chat not opened after 3 seconds
            setTimeout(() => {
                if (chatContainer.classList.contains('show') === false) {
                    exclamation.style.display = 'flex'; // Show the exclamation mark
                }
            }, 3000); // Show the exclamation mark after 3 seconds if not clicked

            // Toggle Chat Visibility
            toggleBtn.addEventListener('click', () => {
                if (chatContainer.style.display === 'none' || chatContainer.style.display === '') {
                    // Show the chat container
                    chatContainer.style.display = 'block';
                    chatContainer.classList.add('show');
                    exclamation.style.display = 'none'; // Hide the exclamation mark if clicked
                } else {
                    // Hide the chat container
                    chatContainer.classList.remove('show');
                    setTimeout(() => {
                        chatContainer.style.display = 'none'; // Set display to none after transition
                    }, 500); // Wait for the transition to complete
                }
            });

            closeBtn.addEventListener('click', () => {
                chatContainer.classList.remove('show');
                setTimeout(() => {
                    chatContainer.style.display = 'none'; // Set display to none after transition
                }, 500); // Wait for the transition to complete
            });

            resetBtn.addEventListener('click', () => {
                currentSequence = 1;
                messagesContainer.innerHTML = '<div class="chat-message bot">👋 Hello! How can I help you?</div>';
                showQuestionsBySequence(currentSequence);
            });

            // Fetch Chatbot Data
            fetch('get_chat_questions.php')
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        // Show a maintenance message if no data is returned
                        const botMsg = document.createElement('div');
                        questionsContainer.innerHTML = '<div class="text-muted">🤖 Chatbot maintenance, <br> please wait for a while!</div>';
                        return; // Exit the function if no data is found
                    }

                    // Otherwise, process the data as usual
                    data.forEach(item => {
                        if (!groupedQuestions[item.sequence]) {
                            groupedQuestions[item.sequence] = [];
                        }
                        groupedQuestions[item.sequence].push(item);
                    });

                    showQuestionsBySequence(currentSequence);
                })
                .catch(error => {
                    // Handle errors that occur during the fetch
                    console.error('Error fetching data:', error);

                    const botMsg = document.createElement('div');
                    botMsg.className = 'chat-message bot maintenance';
                    botMsg.innerHTML = `<strong>Bot:</strong> ⚠️ Chatbot is currently under maintenance. <br> Please try again later.`;

                    messagesContainer.appendChild(botMsg);
                    questionsContainer.innerHTML = '<div class="text-muted">🤖 Chatbot maintenance, please wait for a while!</div>';
                });



            // Show Questions by Sequence
            function showQuestionsBySequence(seq) {
                questionsContainer.innerHTML = '';

                if (groupedQuestions[seq]) {
                    groupedQuestions[seq].forEach(item => {
                        const btn = document.createElement('button');
                        btn.classList.add('btn', 'btn-outline-primary', 'm-1');
                        btn.textContent = item.chat_question;
                        btn.onclick = () => handleUserClick(item.chat_question, item.bot_response);
                        questionsContainer.appendChild(btn);
                    });
                } else {
                    questionsContainer.innerHTML = '<div class="text-muted">🤖 Thank you for using KLL-Bot!</div>';
                }
            }

            // Handle Button Click
            function handleUserClick(question, response) {
                const userMsg = document.createElement('div');
                userMsg.className = 'chat-message user';
                userMsg.innerHTML = `<strong>You:</strong> ${question}`;
                messagesContainer.appendChild(userMsg);

                // Simulate a thinking delay before bot responds
                const typingIndicator = document.createElement('div');
                typingIndicator.className = 'chat-message bot';
                typingIndicator.innerHTML = `<strong>Bot:</strong> Typing...`;
                messagesContainer.appendChild(typingIndicator);

                // Scroll to the bottom
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                // Set delay (for example, 3 seconds) before the bot's actual response
                setTimeout(() => {
                    // Remove the "thinking" indicator
                    typingIndicator.remove();

                    const formattedResponse = response.replace(/\n/g, '<br />');

                    const botMsg = document.createElement('div');
                    botMsg.className = 'chat-message bot';
                    botMsg.innerHTML = `<strong>Bot:</strong> ${formattedResponse}`;
                    messagesContainer.appendChild(botMsg);

                    messagesContainer.scrollTop = messagesContainer.scrollHeight;

                    currentSequence++;
                    setTimeout(() => {
                        showQuestionsBySequence(currentSequence);
                    }, 500);
                }, 2000);
            }

        });
    </script>

</body>

</html>