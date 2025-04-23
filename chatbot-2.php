<!-- CHATBOT -->
<div id="chat-toggle" class="chat-toggle">🤖</div>
<div id="chat-container" class="chat-container">
    <div class="chatbox-wrapper">
        <div class="chatbox">
            <div class="chat-header d-flex justify-content-between align-items-center">
                <strong style="font-size: 20px;">KLL-Bot</strong>
                <div style="float: right !important;">
                    <button id="chat-reset" class="btn btn-sm btn-warning mr-1">RESET CHAT</button>
                    <button id="chat-close" class="btn btn-sm btn-danger">CLOSE</button>
                </div>
            </div>
            <div id="chat-messages" class="chat-messages">
                <div class="chat-message bot" style="color: #1A242F;">👋 Hello! How can I help you?</div>
            </div>
            <div id="chat-questions" class="chat-buttons"></div>
        </div>
    </div>
</div>

<!-- CHATBOT SCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentSequence = 1;
        let groupedQuestions = {};

        const toggleBtn = document.getElementById('chat-toggle');
        const chatContainer = document.getElementById('chat-container');
        const closeBtn = document.getElementById('chat-close');
        const resetBtn = document.getElementById('chat-reset');
        const messagesContainer = document.getElementById('chat-messages');
        const questionsContainer = document.getElementById('chat-questions');

        setTimeout(() => {
            chatContainer.classList.add('show');
        }, 3000);


        toggleBtn.addEventListener('click', () => {
            if (chatContainer.style.display === 'none' || chatContainer.style.display === '') {
                chatContainer.style.display = 'block';
                chatContainer.classList.add('show');
            } else {
                chatContainer.classList.remove('show');
                setTimeout(() => {
                    chatContainer.style.display = 'none';
                }, 500);
            }
        });

        closeBtn.addEventListener('click', () => {
            chatContainer.classList.remove('show');
            setTimeout(() => {
                chatContainer.style.display = 'none';
            }, 500);
        });

        resetBtn.addEventListener('click', () => {
            currentSequence = 1;
            messagesContainer.innerHTML = '<div class="chat-message bot">👋 Hello! How can I help you?</div>';
            showQuestionsBySequence(currentSequence);
        });

        fetch('bot/chat_questions.php')
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    const botMsg = document.createElement('div');
                    questionsContainer.innerHTML = '<div class="text-muted">🤖 Chatbot maintenance, <br> please wait for a while!</div>';
                    return;
                }

                data.forEach(item => {
                    if (!groupedQuestions[item.sequence]) {
                        groupedQuestions[item.sequence] = [];
                    }
                    groupedQuestions[item.sequence].push(item);
                });

                showQuestionsBySequence(currentSequence);
            })
            .catch(error => {
                console.error('Error fetching data:', error);

                const botMsg = document.createElement('div');
                botMsg.className = 'chat-message bot maintenance';
                botMsg.innerHTML = `<strong>Bot 🤖:</strong> ⚠️ Chatbot is currently under maintenance. <br> Please try again later.`;

                messagesContainer.appendChild(botMsg);
                questionsContainer.innerHTML = '<div class="text-muted">🤖 Chatbot maintenance, please wait for a while!</div>';
            });



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

        function handleUserClick(question, response) {
            const userMsg = document.createElement('div');
            userMsg.className = 'chat-message user';
            userMsg.innerHTML = `<strong>You:</strong> ${question}`;
            messagesContainer.appendChild(userMsg);

            const typingIndicator = document.createElement('div');
            typingIndicator.className = 'chat-message bot';
            typingIndicator.innerHTML = `<strong>Bot 🤖:</strong> Typing...`;
            messagesContainer.appendChild(typingIndicator);

            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            setTimeout(() => {
                typingIndicator.remove();

                const formattedResponse = response.replace(/\n/g, '<br />');

                const botMsg = document.createElement('div');
                botMsg.className = 'chat-message bot';
                botMsg.innerHTML = `<strong>Bot 🤖:</strong> ${formattedResponse}`;
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