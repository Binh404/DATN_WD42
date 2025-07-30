@extends('layoutsAdmin.master')
@section('title', 'Chat Messenger')
@section('content')

<div class="container-fluid h-100">
    <div class="row h-100">
        <!-- Sidebar danh sách chat -->
        <div class="col-md-4 col-lg-3 p-0 border-end">
            <div class="chat-sidebar h-100 bg-white">
                <!-- Header sidebar -->
                <div class="p-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Chat</h5>
                    <!-- Search box -->
                    <div class="mt-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-light" placeholder="Tìm kiếm trong Messenger">
                        </div>
                    </div>
                </div>

                <!-- Danh sách cuộc trò chuyện -->
                <div class="chat-list overflow-auto" style="height: calc(100vh - 140px);">
                    <!-- Chat item 1 -->
                   <div id="chatUserList"></div>




                </div>
            </div>
        </div>

        <!-- Khung chat chính -->
        <div class="col-md-8 col-lg-9 p-0 d-flex flex-column">
            <!-- Header chat -->
            <div class="chat-header p-3 border-bottom bg-white">
                <div class="d-flex align-items-center ">
                    {{-- <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-size: 16px; font-weight: 600;">
                        A
                    </div> --}}
                        <div id="avatarTinNhan" class="avatar me-3">
                            <img
                                src="{{ asset( 'assets/images/default.png') }}"
                                alt="avatar"
                                class="rounded-circle"
                                width="40"
                                height="40"
                            >
                        </div>
                        <input type="hidden" id="nguoiNhanId" value="">

                    <div>
                        <h6 class="mb-0 fw-semibold">Nguyễn Văn A</h6>
                        <small class="text-success">Đang hoạt động</small>
                    </div>
                </div>
            </div>

            <!-- Khung tin nhắn -->
            <div class="chat-messages flex-grow-1 overflow-auto p-3" style="height: calc(100vh - 200px); background-color: #fafafa;">
                <!-- Tin nhắn từ người khác -->
                {{-- <div class="message mb-3">
                    <div class="d-flex align-items-start">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 12px; font-weight: 600;">
                            A
                        </div>
                        <div class="message-content">
                            <div class="bg-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                                <p class="mb-0">Xin chào! Bạn có khỏe không?</p>
                            </div>
                            <small class="text-muted ms-2 d-block mt-1" style="font-size: 11px;">14:30</small>
                        </div>
                    </div>
                </div>

                <!-- Tin nhắn của tôi -->
                <div class="message mb-3">
                    <div class="d-flex align-items-start justify-content-end">
                        <div class="message-content">
                            <div class="bg-primary text-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                                <p class="mb-0">Tôi khỏe, cảm ơn bạn! Còn bạn thì sao?</p>
                            </div>
                            <small class="text-muted me-2 d-block mt-1 text-end" style="font-size: 11px;">14:32</small>
                        </div>
                    </div>
                </div>

                <!-- Tin nhắn với emoji -->
                <div class="message mb-3">
                    <div class="d-flex align-items-start">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 12px; font-weight: 600;">
                            A
                        </div>
                        <div class="message-content">
                            <div class="bg-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                                <p class="mb-0">Tôi cũng ổn! 😊</p>
                            </div>
                            <small class="text-muted ms-2 d-block mt-1" style="font-size: 11px;">14:35</small>
                        </div>
                    </div>
                </div>

                <div class="message mb-3">
                    <div class="d-flex align-items-start">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 12px; font-weight: 600;">
                            A
                        </div>
                        <div class="message-content">
                            <div class="bg-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                                <p class="mb-0">Hôm nay làm việc thế nào?</p>
                            </div>
                            <small class="text-muted ms-2 d-block mt-1" style="font-size: 11px;">14:36</small>
                        </div>
                    </div>
                </div>

                <!-- Tin nhắn của tôi -->
                <div class="message mb-3">
                    <div class="d-flex align-items-start justify-content-end">
                        <div class="message-content">
                            <div class="bg-primary text-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                                <p class="mb-0">Hôm nay khá bận, nhưng mọi thứ đều ổn</p>
                            </div>
                            <small class="text-muted me-2 d-block mt-1 text-end" style="font-size: 11px;">14:40</small>
                        </div>
                    </div>
                </div> --}}

                <!-- Typing indicator -->
                {{-- <div class="message mb-3" id="typing-indicator" style="display: none;">
                    <div class="d-flex align-items-start">
                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 12px; font-weight: 600;">
                            A
                        </div>
                        <div class="message-content">
                            <div class="bg-white rounded-4 p-3 shadow-sm">
                                <div class="typing-animation">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Khung nhập tin nhắn -->
            <div class="chat-input p-3 bg-white">
                <div class="d-flex align-items-center bg-light rounded-pill px-3 py-2">
                    <button class="btn p-1 me-2" type="button">
                        <i class="fas fa-plus text-primary"></i>
                    </button>
                    <input type="text" class="form-control border-0 bg-transparent" placeholder="Aa" id="messageInput" style="font-size: 15px;">
                    <button class="btn p-1 ms-2" type="button">
                        <i class="far fa-smile text-primary"></i>
                    </button>
                    <button class="btn p-1 ms-1" type="button" onclick="sendMessage()">
                        <i class="fas fa-paper-plane text-primary"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-item {
    transition: background-color 0.15s ease;
    border-radius: 8px;
    margin: 0 8px;
}

.chat-item:hover {
    background-color: #f2f2f2 !important;
}

.chat-item.active {
    background-color: #e7f3ff !important;
}

.cursor-pointer {
    cursor: pointer;
}

.message-content {
    animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}

.typing-animation {
    display: flex;
    align-items: center;
    height: 16px;
}

.typing-animation span {
    height: 4px;
    width: 4px;
    background-color: #65676b;
    border-radius: 50%;
    display: inline-block;
    margin-right: 2px;
    animation: typing 1.4s infinite;
}

.typing-animation span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-animation span:nth-child(3) {
    animation-delay: 0.4s;
    margin-right: 0;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.5;
    }
    30% {
        transform: translateY(-4px);
        opacity: 1;
    }
}

.chat-messages::-webkit-scrollbar {
    width: 4px;
}

.chat-messages::-webkit-scrollbar-track {
    background: transparent;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #bdbdbd;
    border-radius: 2px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #9e9e9e;
}

.chat-list::-webkit-scrollbar {
    width: 4px;
}

.chat-list::-webkit-scrollbar-track {
    background: transparent;
}

.chat-list::-webkit-scrollbar-thumb {
    background: #bdbdbd;
    border-radius: 2px;
}

.avatar {
    flex-shrink: 0;
}

.chat-input input:focus {
    outline: none;
    box-shadow: none;
}

.chat-input .btn:focus {
    outline: none;
    box-shadow: none;
}

.bg-light {
    background-color: #f0f2f5 !important;
}
</style>

<script>
// function selectChat(chatId) {
//     // Remove active class from all chat items
//     document.querySelectorAll('.chat-item').forEach(item => {
//         item.classList.remove('active');
//     });

//     // Add active class to selected chat
//     event.currentTarget.classList.add('active');

//     // Update chat header based on chatId
//     const names = ['', 'Nguyễn Văn A', 'Trần Thị B', 'Lê Văn C', 'Phạm Thị D', 'Hoàng Văn E'];
//     const letters = ['', 'A', 'B', 'C', 'D', 'E'];
//     const colors = ['', 'bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger'];

//     if (chatId <= 5) {
//         document.querySelector('.chat-header h6').textContent = names[chatId];
//         document.querySelector('.chat-header .avatar').textContent = letters[chatId];
//         document.querySelector('.chat-header .avatar').className = `avatar ${colors[chatId]} text-white rounded-circle d-flex align-items-center justify-content-center me-3`;
//     }
// }
async function getChatUsers() {
    try {
        const response = await fetch('/api/chat/users', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            const chatList = document.getElementById('chatUserList');
            chatList.innerHTML = '';

            data.data.forEach(user => {
                const chatItem = `
                    <div class="chat-item p-3 cursor-pointer" onclick="getMessages(${user.id})">
                        <div class="d-flex align-items-center">
                            <div class="position-relative">
                                <div class="avatar">
                                    <img src="${user.avatar ? '/' + user.avatar : '/assets/images/default.png'}"
                                         alt="" class="rounded-circle" width="40" height="40">
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 fw-semibold">${user.name}</h6>
                                </div>
                                <p class="mb-0 text-muted small">
                                    ${user.last_message ? (user.last_message.is_own ? 'Bạn: ' : '') + user.last_message.content : 'Chưa có tin nhắn'}
                                </p>
                                ${user.last_message ? `<small class="text-muted"  style="font-size: 11px;">${user.last_message.time}</small>` : ''}

                            </div>
                            ${user.unread_count > 0 ? `<span class="badge bg-danger rounded-pill ms-2" id="unreadCount-${user.id}">${user.unread_count}</span>` : ''}
                        </div>
                    </div>
                `;
                chatList.insertAdjacentHTML('beforeend', chatItem);
            });
        } else {
            console.error('Error:', data.message);
            return [];
        }
    } catch (error) {
        console.error('Network error:', error);
        return [];
    }
}

// Lấy CSRF token nếu dùng Laravel session
function getCSRFToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}
async function getMessages(userId) {
     const badge = document.getElementById(`unreadCount-${userId}`);
    if (badge) {
        badge.style.display = 'none'; // hoặc badge.classList.add('d-none');
    }
    try {
        const response = await fetch('{{ route('chat.show', ':id') }}'.replace(':id', userId), {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            displayMessages(data.data.messages, data.data.user);
            return data.data;
        } else {
            console.error('Error:', data.message);
            return null;
        }
    } catch (error) {
        console.error('Network error:', error);
        return null;
    }
}
// Hiển thị tin nhắn trong giao diện
function displayMessages(messages, user) {
    const chatMessages = document.querySelector('.chat-messages');
    chatMessages.innerHTML = '';
    const avatarDiv = document.getElementById('avatarTinNhan');
    // console.log(avatarDiv);
    avatarDiv.innerHTML = '';
    // Update chat header
    const img = document.createElement('img');
        img.src = user.avatar ? `{{ asset('') }}${user.avatar}` : "{{ asset('assets/images/default.png') }}";
        img.alt = 'avatar';
        img.width = 40;
        img.height = 40;
        img.className = 'rounded-circle';

    avatarDiv.appendChild(img);
    document.querySelector('.chat-header h6').textContent = user.name;
    const nguoiNhanId = document.getElementById('nguoiNhanId');
    nguoiNhanId.value = user.id;
    // console.log(nguoiNhanId.value);
    messages.forEach(message => {
        addMessageToChat(message, false);
    });

    // Scroll to bottom
    chatMessages.scrollTop = chatMessages.scrollHeight;
}
// Thêm tin nhắn vào chat
function addMessageToChat(message, scroll = true) {
    const chatMessages = document.querySelector('.chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = 'message mb-3';

    if (message.is_own_message) {
        // Tin nhắn của mình
        messageDiv.innerHTML = `
            <div class="d-flex align-items-start justify-content-end">
                <div class="message-content">
                    <div class="bg-primary text-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                        <p class="mb-0">${message.content}</p>
                    </div>
                    <small class="text-muted me-2 d-block mt-1 text-end" style="font-size: 11px;">${message.created_at}</small>
                </div>
            </div>
        `;
    } else {
        // Tin nhắn của người khác
        const imgSrc = message.sender.avatar
            ? `{{ asset('') }}${message.sender.avatar}`
            : `{{ asset('assets/images/default.png') }}`;
        messageDiv.innerHTML = `
            <div class="d-flex align-items-start">
                <div class="avatar me-3">
                    <img src="${imgSrc}" alt="avatar" class="rounded-circle" width="40" height="40">
                </div>

                <div class="message-content">
                    <div class="bg-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                        <p class="mb-0">${message.content}</p>
                    </div>
                    <small class="text-muted ms-2 d-block mt-1" style="font-size: 11px;">${message.created_at}</small>
                </div>
            </div>
        `;
    }

    chatMessages.appendChild(messageDiv);

    if (scroll) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
}
async function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();

    if (message) {
        // Create new message element
        const chatMessages = document.querySelector('.chat-messages');
        const messageDiv = document.createElement('div');
        const nguoiNhanId = document.getElementById('nguoiNhanId').value;
        // console.log(nguoiNhanId);
        messageDiv.className = 'message mb-3';
        messageDiv.innerHTML = `
            <div class="d-flex align-items-start justify-content-end">
                <div class="message-content">
                    <div class="bg-primary text-white rounded-4 p-2 shadow-sm" style="max-width: 280px;">
                        <p class="mb-0">${message}</p>
                    </div>
                    <small class="text-muted me-2 d-block mt-1 text-end" style="font-size: 11px;">${new Date().toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'})}</small>
                </div>
            </div>
        `;

        chatMessages.appendChild(messageDiv);

        // Clear input
        input.value = '';

        // Scroll to bottom
        chatMessages.scrollTop = chatMessages.scrollHeight;

        const  sentMessage = sendMessageAPI(nguoiNhanId, message);
        if (!sentMessage) {
            // Restore input if failed
            input.value = message;
            alert('Không thể gửi tin nhắn. Vui lòng thử lại.');
        }
        await getChatUsers();
        // // Show typing indicator after a delay (simulate response)
        // setTimeout(() => {
        //     document.getElementById('typing-indicator').style.display = 'block';
        //     chatMessages.scrollTop = chatMessages.scrollHeight;

        //     // Hide typing indicator after another delay
        //     setTimeout(() => {
        //         document.getElementById('typing-indicator').style.display = 'none';
        //     }, 2000);
        // }, 800);
    }
}

// Enter key to send message
document.getElementById('messageInput').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});
async function sendMessageAPI(receiverId, content) {
    try {
        const response = await fetch('/api/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCSRFToken(),
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                receiver_id: receiverId,
                content: content
            })
        });

        const data = await response.json();

        if (data.success) {
            // addMessageToChat(data.data);
            return data.data;
        } else {
            console.error('Error:', data.message);
            return null;
        }
    } catch (error) {
        console.error('Network error:', error);
        return null;
    }
}

// Auto scroll to bottom on page load
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.querySelector('.chat-messages');
    chatMessages.scrollTop = chatMessages.scrollHeight;
    getChatUsers();
    getMessages(1);
});
</script>

@endsection
