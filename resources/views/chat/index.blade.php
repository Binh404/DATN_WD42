@extends('layoutsAdmin.master')
@section('title', 'Chat Messenger')
@section('style')
    {{-- @vite(['resources/js/bootstrap.js']) --}}
@endsection
@section('content')

    <div class="container-fluid h-100">
        <div class="row h-100">
            <!-- Sidebar danh sách chat -->
            <div class="col-md-4 col-lg-3 p-0 border-end">
                <div class="chat-sidebar h-100 bg-white">
                    <!-- Header sidebar -->
                    <div class="p-3 border-bottom ">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold">Trò chuyện</h5>
                            <!-- Settings button -->
                            <div class="dropdown">
                                <button class="btn btn-link p-1" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <button class="dropdown-item" onclick="toggleNotificationSound()">
                                            <i class="fas fa-volume-up me-2"></i>
                                            <span id="soundToggleText">Tắt âm thanh</span>
                                        </button>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <button class="dropdown-item" onclick="markAllAsRead()">
                                            <i class="fas fa-check-double me-2"></i>
                                            Đánh dấu đã đọc tất cả
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- Search box -->
                        <div class="mt-3">
                            <div class="input-group">
                                <span class="input-group-text border-0 rounded-start-pill bg-primary">
                                    <i class="fas fa-search text-white"></i>
                                </span>
                                <input type="text" id="searchInput"
                                    class="form-control border-0 bg-primary text-white rounded-end-pill"
                                    placeholder="Tìm kiếm cuộc trò chuyện..." onkeyup="searchChats()">
                            </div>
                        </div>

                    </div>

                    <!-- Danh sách cuộc trò chuyện -->
                    <div class="chat-list overflow-auto" style="height: calc(100vh - 160px);">
                        <div id="chatUserList"></div>
                        <!-- Loading indicator -->
                        <div id="chatLoading" class="text-center py-4" style="display: none;">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Khung chat chính -->
            <div class="col-md-8 col-lg-9 p-0 d-flex flex-column">
                <!-- Chat welcome screen -->
                <div id="chatWelcome"
                    class="d-flex flex-column justify-content-center align-items-center h-100 text-center">
                    <div class="mb-4">
                        <i class="fas fa-comments text-primary" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h4 class="text-muted mb-2">Chào mừng đến với Messenger</h4>
                    <p class="text-muted">Chọn một cuộc trò chuyện để bắt đầu nhắn tin</p>
                </div>

                <!-- Chat container -->
                <div id="chatContainer" class="d-flex flex-column h-100" style="display: none !important;">
                    <!-- Header chat -->
                    <div class="chat-header p-3 border-bottom bg-white shadow-sm">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div id="avatarTinNhan" class="avatar me-3 position-relative">
                                    <img src="{{ asset('assets/images/default.png') }}" alt="avatar"
                                        class="rounded-circle border" width="45" height="45">
                                    <!-- Online status indicator -->
                                    <span
                                        class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle"
                                        style="width: 12px; height: 12px;" id="onlineStatus"></span>
                                </div>
                                <input type="hidden" id="nguoiNhanId" value="">
                                <div>
                                    <h6 class="mb-0 fw-semibold" id="chatUserName">Người dùng</h6>
                                    <small class="text-success" id="userStatus">Đang hoạt động</small>
                                </div>
                            </div>

                            <!-- Chat actions -->
                            <div class="d-flex gap-2">
                                <button class="btn btn-light btn-sm rounded-circle" onclick="startVideoCall()"
                                    title="Gọi video">
                                    <i class="fas fa-video text-primary"></i>
                                </button>
                                <button class="btn btn-light btn-sm rounded-circle" onclick="toggleChatInfo()"
                                    title="Thông tin">
                                    <i class="fas fa-info-circle text-primary"></i>
                                </button>
                            </div>
                        </div>
                    </div>



                    <!-- Khung tin nhắn -->
                    <div class="chat-messages flex-grow-1 overflow-auto p-3" id="chatMessages"
                        style="height: calc(100vh - 200px);  background-attachment: fixed;">
                        <!-- Messages will be loaded here -->
                    </div>

                    <!-- Message reactions popup -->
                    <div id="reactionPopup" class="position-fixed bg-white rounded-pill shadow-lg p-2"
                        style="display: none; z-index: 1001;">
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm reaction-btn" data-reaction="❤️">❤️</button>
                            <button class="btn btn-sm reaction-btn" data-reaction="😂">😂</button>
                            <button class="btn btn-sm reaction-btn" data-reaction="😮">😮</button>
                            <button class="btn btn-sm reaction-btn" data-reaction="😢">😢</button>
                            <button class="btn btn-sm reaction-btn" data-reaction="😡">😡</button>
                            <button class="btn btn-sm reaction-btn" data-reaction="👍">👍</button>
                            <button class="btn btn-sm reaction-btn" data-reaction="👎">👎</button>
                        </div>
                    </div>
                    <!-- Typing indicator -->
                    <div id="typingIndicator" class="px-3 py-1 bg-light border-bottom" style="display: none;">
                        <small class="text-muted">
                            <span id="typingUserName">Người dùng</span> đang soạn tin...
                            <div class="typing-dots d-inline-block ms-2">
                                <span></span><span></span><span></span>
                            </div>
                        </small>
                    </div>

                    <!-- Khung nhập tin nhắn -->
                    <div class="chat-input p-3 bg-white border-top" id="messageInputContainer">
                        <div class="d-flex align-items-center bg-light rounded-pill px-2 py-1 position-relative shadow-sm">

                            <!-- File upload -->
                            <button class="btn p-1 me-1 rounded-circle" type="button"
                                onclick="document.getElementById('fileInput').click()">
                                <i class="fas fa-plus-circle text-primary fs-5"></i>
                            </button>
                            <input type="file" id="fileInput" style="display: none;" multiple
                                accept="image/*,video/*,.pdf,.doc,.docx" onchange="handleFileUpload(event)">
                            <div id="voicePreview" class="mt-2 p-2" style="display:none; background:#f9f9f9; border-radius:8px;"></div>

                            <!-- Message input -->
                            <div class="flex-grow-1 mx-1 position-relative">
                                <textarea class="form-control border-0 bg-transparent resize-none shadow-none"
                                    placeholder="Aa" id="messageInput" rows="1" style="font-size: 15px; max-height: 80px;"
                                    oninput="adjustTextareaHeight(this); handleTyping()"
                                    onkeydown="handleKeyDown(event)"></textarea>

                                <!-- File preview area -->
                                <div id="filePreview" class="mt-2" style="display: none;"></div>
                            </div>

                            <!-- Emoji button -->
                            <button id="emojiBtn" class="btn p-1 ms-1 rounded-circle" type="button"
                                title="Thêm biểu tượng cảm xúc">
                                <i class="far fa-smile text-primary fs-5"></i>
                            </button>

                            <!-- Send button -->
                            <button class="btn p-1 ms-1 rounded-circle" type="button" onclick="sendMessage()" id="sendBtn">
                                <i class="fas fa-paper-plane text-primary fs-5"></i>
                            </button>

                            <!-- Voice message button -->
                            <button class="btn p-1 ms-1 rounded-circle" type="button" onclick="toggleVoiceRecording()"
                                id="voiceBtn">
                                <i class="fas fa-microphone text-primary fs-5"></i>
                            </button>
                        </div>

                        <!-- Emoji picker -->
                        <emoji-picker id="emojiPicker" style="position: absolute; bottom: 20px; right: 20px; display: none; z-index: 1000;
                                      border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);"></emoji-picker>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Notification sound -->
    <audio id="notificationSound" preload="auto">
         <source src="{{ asset('amThanh/new-notification.mp3') }}" type="audio/mpeg" />
    </audio>

    <style>
        /* Enhanced UI Styles */
        .bg-gradient-primary {
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        }


        .chat-item {
            transition: all 0.2s ease;
            border-radius: 12px;
            margin: 4px 8px;
            position: relative;
            overflow: hidden;
        }

        .chat-item:hover {
            background-color: #f8f9fa !important;
            transform: translateX(2px);
        }

        .chat-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .chat-item.active .text-muted {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .chat-item.unread {
            border-left: 4px solid #667eea;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .message-content {
            animation: messageSlideIn 0.3s ease;
        }

        @keyframes messageSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Message bubbles */
        .message-bubble {
            max-width: 280px;
            word-wrap: break-word;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .message-bubble:hover {
            transform: scale(1.02);
        }

        .message-bubble.own {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin-left: auto;
        }

        .message-bubble.other {
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Typing animation */
        .typing-dots span {
            height: 4px;
            width: 4px;
            background-color: #65676b;
            border-radius: 50%;
            display: inline-block;
            margin-right: 2px;
            animation: typingDots 1.4s infinite;
        }

        .typing-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dots span:nth-child(3) {
            animation-delay: 0.4s;
            margin-right: 0;
        }

        @keyframes typingDots {

            0%,
            60%,
            100% {
                transform: translateY(0);
                opacity: 0.5;
            }

            30% {
                transform: translateY(-3px);
                opacity: 1;
            }
        }

        /* Scrollbar styling */
        .chat-messages::-webkit-scrollbar,
        .chat-list::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track,
        .chat-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb,
        .chat-list::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover,
        .chat-list::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.4);
        }

        /* Enhanced input styling */
        .chat-input textarea {
            resize: none;
            overflow-y: auto;
        }

        .chat-input textarea:focus {
            outline: none;
            box-shadow: none;
        }

        .chat-input .btn:focus {
            outline: none;
            box-shadow: none;
        }

        .chat-input .btn:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        /* File preview */
        .file-preview-item {
            position: relative;
            display: inline-block;
            margin: 5px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .file-preview-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            cursor: pointer;
        }

        /* Reaction buttons */
        .reaction-btn {
            font-size: 18px;
            border: none;
            background: transparent;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            transition: all 0.2s ease;
        }

        .reaction-btn:hover {
            background: #f0f2f5;
            transform: scale(1.2);
        }

        /* Message reactions */
        .message-reactions {
            position: absolute;
            bottom: -8px;
            right: 10px;
            background: white;
            border-radius: 12px;
            padding: 2px 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 12px;
        }

        /* Online status */
        .online-indicator {
            width: 12px;
            height: 12px;
            background: #42b883;
            border: 2px solid white;
            border-radius: 50%;
            position: absolute;
            bottom: 0;
            right: 0;
        }

        /* Badge styling */
        .badge-notification {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Text ellipsis */
        .text-ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        /* Voice recording animation */
        .recording {
            animation: recordingPulse 1s infinite;
        }

        @keyframes recordingPulse {
            0% {
                background: #ff4757;
            }

            50% {
                background: #ff3838;
            }

            100% {
                background: #ff4757;
            }
        }

        /* Search highlight */
        .search-highlight {
            background: #fff3cd;
            border-radius: 4px;
            padding: 2px 4px;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .chat-item {
                margin: 2px 4px;
                padding: 12px !important;
            }

            .message-bubble {
                max-width: 250px;
            }

            .chat-header {
                padding: 15px !important;
            }
        }

        /* Loading animation */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        /* Enhanced emoji picker */
        emoji-picker {
            --border-radius: 12px;
            --border-color: #e1e5e9;
            --background: #ffffff;
        }
    </style>

    <script type="module" src="https://cdn.jsdelivr.net/npm/emoji-picker-element@^1/index.js"></script>

    <script>
        // Global variables
        let currentChatUserId = null;
        let isNotificationEnabled = true;
        let typingTimer = null;
        let isTyping = false;
        let recordingAudio = false;
        let mediaRecorder = null;
        let audioChunks = [];
        let selectedFiles = [];
        let lastMessageId = null;
        let recordedAudioBlob = null;
        let recordedAudioFile = null;
        // let receiverId = null;
        // DOM elements
        const emojiBtn = document.getElementById('emojiBtn');
        const emojiPicker = document.getElementById('emojiPicker');
        const messageInput = document.getElementById('messageInput');
        const notificationSound = document.getElementById('notificationSound');
        const chatWelcome = document.getElementById('chatWelcome');
        const chatContainer = document.getElementById('chatContainer');
        const reactionPopup = document.getElementById('reactionPopup');

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            initializeChat();
            setupEventListeners();
            requestNotificationPermission();
        });

        // Setup event listeners
        function setupEventListeners() {
            // Emoji picker
            emojiBtn.addEventListener('click', toggleEmojiPicker);
            emojiPicker.addEventListener('emoji-click', handleEmojiSelect);

            // Click outside to close emoji picker
            document.addEventListener('click', function (e) {
                if (!emojiBtn.contains(e.target) && !emojiPicker.contains(e.target)) {
                    emojiPicker.style.display = 'none';
                }
            });

            // Message reactions
            document.addEventListener('click', function (e) {
                if (!reactionPopup.contains(e.target)) {
                    reactionPopup.style.display = 'none';
                }
            });
        }

        // Initialize chat system
        // function initializeChat() {
        //     if (typeof window.Echo === 'undefined') {
        //         console.error('Echo chưa được khởi tạo!');
        //         return;
        //     }

        //     const userId = {{ auth()->id() }};

        //     // Listen for incoming messages
        //     window.Echo.private(`chat.${userId}`)
        //         .listen('.message.sent', (e) => {
        //             console.log('📩 Nhận tin nhắn:', e);
        //             handleIncomingMessage(e);
        //         })
        //         .listen('.user.typing', (e) => {
        //             handleUserTyping(e);
        //         })
        //         .listen('.user.stopped-typing', (e) => {
        //             handleUserStoppedTyping(e);
        //         });

        //     // Load chat users
        //     getChatUsers();
        // }
        // Initialize chat system
function initializeChat() {
    if (typeof window.Echo === 'undefined') {
        console.error('Echo chưa được khởi tạo!');
        return;
    }

    const userId = {{ auth()->id() }};
    window.Echo.connector.pusher.connection.bind('connected', () => {
        console.log('Đã kết nối WebSocket thành công với server Reverb!');
    });

    window.Echo.connector.pusher.connection.bind('disconnected', () => {
        console.log('Đã ngắt kết nối WebSocket với server Reverb!');
    });
    // Dùng Reverb để lắng nghe
    window.Echo.private(`chat.${userId}`)
        .listen('.message.sent', (e) => {
            console.log('📩 Nhận tin nhắn:', e);
            handleIncomingMessage(e);
        })
        .listen('.user.typing', (e) => {
            console.log('User started typing:', e);
            handleUserTyping(e);
        })
        .listen('.user.stopped-typing', (e) => {
            console.log('User stopped typing:', e);
            handleUserStoppedTyping(e);
        });

    // Load chat users
    getChatUsers();
}

        // Handle incoming messages
        function handleIncomingMessage(message) {
            // Play notification sound
            // playNotificationSound();

            // Show browser notification
            showBrowserNotification(message);

            // Update UI if chatting with sender
            if (currentChatUserId && message.sender_id == currentChatUserId) {
                addMessageToChat(message, true, false);
            }

            // Update chat list
            getChatUsers();
        }

        // Play notification sound
        function playNotificationSound() {
            console.log('Phép nhán tin nhắn:', isNotificationEnabled);
            if (isNotificationEnabled) {
                notificationSound.currentTime = 0;
                notificationSound.play().catch(e => console.log('Cannot play sound:', e));
            }
        }

        // Show browser notification
        function showBrowserNotification(message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                const notification = new Notification(`Tin nhắn mới từ ${message.sender.name}`, {
                    body: message.content,
                    icon: message.sender.avatar || '/assets/images/default.png',
                    badge: '/assets/images/default.png'
                });

                notification.onclick = function () {
                    window.focus();
                    if (message.sender_id != currentChatUserId) {
                        selectAndGetMessages(message.sender_id);
                    }
                    notification.close();
                };

                setTimeout(() => notification.close(), 5000);
            }
        }

        // Request notification permission
        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        // Toggle notification sound
        function toggleNotificationSound() {
            isNotificationEnabled = !isNotificationEnabled;
            const soundToggleText = document.getElementById('soundToggleText');
            soundToggleText.textContent = isNotificationEnabled ? 'Tắt âm thanh' : 'Bật âm thanh';

            // Show feedback
            showToast(isNotificationEnabled ? 'Đã bật âm thanh thông báo' : 'Đã tắt âm thanh thông báo');
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `p-3 mb-2 rounded shadow text-white bg-${type} position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 1100; min-width: 250px;';
            toast.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>${message}</div>
                    <button type="button" class="btn-close btn-close-white ms-2" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentElement) toast.remove();
            }, 3000);
        }


        // Search chats
        function searchChats() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const chatItems = document.querySelectorAll('.chat-item');

            chatItems.forEach(item => {
                const userName = item.querySelector('h6').textContent.toLowerCase();
                const lastMessage = item.querySelector('.text-ellipsis').textContent.toLowerCase();

                if (userName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                    item.style.display = 'block';
                    // Highlight search term
                    if (searchTerm) {
                        highlightSearchTerm(item, searchTerm);
                    }
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Highlight search term
        function highlightSearchTerm(element, term) {
            const textElements = element.querySelectorAll('h6, .text-ellipsis');
            textElements.forEach(el => {
                const text = el.textContent;
                const regex = new RegExp(`(${term})`, 'gi');
                el.innerHTML = text.replace(regex, '<span class="search-highlight">$1</span>');
            });
        }

        // Get chat users
        async function getChatUsers() {
            document.getElementById('chatLoading').style.display = 'block';

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
                    displayChatUsers(data.data);
                } else {
                    console.error('Error:', data.message);
                }
            } catch (error) {
                console.error('Network error:', error);
                showToast('Lỗi kết nối mạng', 'danger');
            } finally {
                document.getElementById('chatLoading').style.display = 'none';
            }
        }

        // Display chat users
        function displayChatUsers(users) {
            const chatList = document.getElementById('chatUserList');
            chatList.innerHTML = '';

            users.forEach(user => {
                const isActive = currentChatUserId == user.id ? 'active' : '';
                const unreadClass = user.unread_count > 0 ? 'unread' : '';
                // const lastMessage = user.last_message.content ?? 'Đã gửi file'
                const chatItem = `
                 <div class="chat-item px-2 py-2 cursor-pointer ${isActive} ${unreadClass}" onclick="selectAndGetMessages(${user.id})">
                    <div class="d-flex align-items-center">
                        <!-- Avatar + trạng thái online -->
                        <div class="position-relative me-2">
                        <img src="${user.avatar ? '/' + user.avatar : '/assets/images/default.png'}"
                            alt="" class="rounded-circle border" width="42" height="42">
                        <span class="online-indicator"></span>
                        </div>

                        <!-- Tên + tin nhắn cuối -->
                        <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold" style="font-size: 14px;">${user.name}</h6>
                            ${user.last_message ? `<small class="text-muted" style="font-size: 11px;">${user.last_message.time}</small>` : ''}
                        </div>
                        <p class="text-ellipsis mb-0 ${user.unread_count > 0 ? 'fw-semibold text-dark' : 'text-muted'}" style="font-size: 12px;">
                            ${user.last_message ? (user.last_message.is_own ? 'Bạn: ' : '') + user.last_message.content : 'Chưa có tin nhắn'}
                        </p>
                        </div>

                        <!-- Badge chưa đọc -->
                        ${user.unread_count > 0 ? `
                        <span class="badge bg-primary rounded-pill ms-2" id="unreadCount-${user.id}" style="font-size: 11px; min-width: 18px;">
                        ${user.unread_count}
                        </span>` : ''}
                    </div>
                    </div>

                    `;
                chatList.insertAdjacentHTML('beforeend', chatItem);
            });
        }

        // Select and get messages
        function selectAndGetMessages(userId) {
            // Update UI state
            document.querySelectorAll('.chat-item').forEach(item => {
                item.classList.remove('active');
            });
            event.currentTarget.classList.add('active');

            // Hide welcome screen, show chat
            chatWelcome.classList.remove('d-flex');
            chatWelcome.style.display = 'none';
            chatContainer.style.display = 'flex';

            // Update current chat user
            currentChatUserId = userId;

            // Hide unread badge
            const badge = document.getElementById(`unreadCount-${userId}`);
            if (badge) {
                badge.style.display = 'none';
            }

            // Load messages
            getMessages(userId);
        }

        // Get messages
        async function getMessages(userId) {
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
                } else {
                    console.error('Error:', data.message);
                    showToast('Không thể tải tin nhắn', 'danger');
                }
            } catch (error) {
                console.error('Network error:', error);
                showToast('Lỗi kết nối mạng', 'danger');
            }
        }

        // Display messages
        function displayMessages(messages, user) {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.innerHTML = '';

            // Update chat header
            updateChatHeader(user);

            // Add messages
            messages.forEach(message => {
                addMessageToChat(message, false, true);
            });

            // Scroll to bottom
            scrollToBottom();
        }

        // Update chat header
        function updateChatHeader(user) {
            const avatarDiv = document.getElementById('avatarTinNhan');
            const img = avatarDiv.querySelector('img');
            img.src = user.avatar ? `{{ asset('') }}${user.avatar}` : "{{ asset('assets/images/default.png') }}";

            document.getElementById('chatUserName').textContent = user.name;
            document.getElementById('nguoiNhanId').value = user.id;

            // Update online status (you can implement real-time status later)
            document.getElementById('userStatus').textContent = 'Đang hoạt động';
        }

        // Add message to chat
        function addMessageToChat(message, playSound = false, isInitialLoad = false) {
            const chatMessages = document.getElementById('chatMessages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message mb-3';
            messageDiv.setAttribute('data-message-id', message.id);

            const isOwn = message.is_own_message;
            const messageTime = message.created_at || formatTime(new Date());

            // ✅ Nội dung message (ảnh, file, text)
            let messageBody = '';
            if (message.message_type === 'image' && message.file_url) {
                messageBody = `<img src="${message.file_url}" class="img-fluid rounded-3" style="max-width: 150px; max-height: 150px;">`;
            } else if (message.message_type === 'file' && message.file_url) {
                const fileName = message.file_url.split('/').pop();
                messageBody = `<a href="${message.file_url}" target="_blank" class="text-decoration-none">📎 ${fileName}</a>`;
            } else if (message.message_type === 'audio' && message.file_url) {
                messageBody = `
                    <audio controls style="max-width: 200px;">
                        <source src="${message.file_url}" type="audio/mpeg">
                        <source src="${message.file_url}" type="audio/wav">
                        <source src="${message.file_url}" type="audio/ogg">
                        Bạn khóa tài liệu này.
                    </audio>
                `;
            } else{
                const content = message.message || message.content || '';
                messageBody = `<p class="mb-0">${content}</p>`;
            }

            // ✅ Lấy avatar người gửi
            const senderAvatar = message.sender && message.sender.avatar ?
                `{{ asset('') }}${message.sender.avatar}` :
                '{{ asset('assets/images/default.png') }}';

            if (isOwn) {
                // Tin nhắn của mình (có avatar bên phải)
                messageDiv.innerHTML = `
                    <div class="d-flex align-items-start justify-content-end">
                        <div class="message-content text-end me-2">
                            <div class="message-bubble own bg-primary text-white rounded-4 p-3 shadow-sm position-relative"
                                oncontextmenu="showMessageOptions(event, ${message.id})">
                                ${messageBody}
                                <div class="message-reactions" style="display: none;"></div>
                            </div>
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">
                                ${messageTime}
                                <i class="fas fa-check text-primary ms-1" title="Đã gửi"></i>
                            </small>
                        </div>

                    </div>
                `;
            } else {
                // Tin nhắn của người khác (avatar bên trái)
                messageDiv.innerHTML = `
                    <div class="d-flex align-items-start">
                        <div class="avatar me-2">
                            <img src="${senderAvatar}" alt="avatar" class="rounded-circle border" width="35" height="35">
                        </div>
                        <div class="message-content">
                            <div class="message-bubble other bg-white rounded-4 p-3 shadow-sm position-relative"
                                oncontextmenu="showMessageOptions(event, ${message.id})">
                                ${messageBody}
                                <div class="message-reactions" style="display: none;"></div>
                            </div>
                            <small class="text-muted ms-2 d-block mt-1" style="font-size: 11px;">${messageTime}</small>
                        </div>
                    </div>
                `;
            }

            chatMessages.appendChild(messageDiv);

            if (playSound && !isInitialLoad) {
                playNotificationSound();
            }

            if (!isInitialLoad) {
                scrollToBottom();
            }
        }


        // Scroll to bottom
        function scrollToBottom() {
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Show message options (right-click context menu)
        function showMessageOptions(event, messageId) {
            event.preventDefault();

            // Position reaction popup
            reactionPopup.style.left = event.pageX + 'px';
            reactionPopup.style.top = (event.pageY - 50) + 'px';
            reactionPopup.style.display = 'block';
            reactionPopup.setAttribute('data-message-id', messageId);

            // Add reaction click handlers
            document.querySelectorAll('.reaction-btn').forEach(btn => {
                btn.onclick = () => addReaction(messageId, btn.getAttribute('data-reaction'));
            });
        }

        // Add reaction to message
        function addReaction(messageId, reaction) {
            // Hide popup
            reactionPopup.style.display = 'none';

            // Find message element
            const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
            if (messageElement) {
                const reactionsDiv = messageElement.querySelector('.message-reactions');
                reactionsDiv.innerHTML = reaction;
                reactionsDiv.style.display = 'block';
            }

            // You can send this to server to save reaction
            console.log(`Added reaction ${reaction} to message ${messageId}`);
        }

        // Handle typing
        function handleTyping() {
            if (!currentChatUserId) return;

            if (!isTyping) {
                isTyping = true;
                // Send typing event to server
                sendTypingEvent(true);
            }

            // Clear existing timer
            clearTimeout(typingTimer);

            // Set timer to stop typing
            typingTimer = setTimeout(() => {
                isTyping = false;
                sendTypingEvent(false);
            }, 8000);
        }

        // Send typing event
        function sendTypingEvent(typing) {
            // You can implement WebSocket typing events here
            console.log(typing ? 'User started typing' : 'User stopped typing');

            const url = typing ? '/chat/typing' : '/chat/stopped-typing';

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ receiver_id: currentChatUserId }), // receiverId là biến ID người nhận bạn đã xác định
            }).catch(e => console.error('Error sending typing event:', e));
        }

        // Handle user typing
        function handleUserTyping(data) {
            if (data.user_id == currentChatUserId) {
                // console.log('User started typing:', data.user_name);
                const typingIndicator = document.getElementById('typingIndicator');
                document.getElementById('typingUserName').textContent = data.user_name;
                typingIndicator.style.display = 'block';
            }
        }

        // Handle user stopped typing
        function handleUserStoppedTyping(data) {
            if (data.user_id == currentChatUserId) {
                document.getElementById('typingIndicator').style.display = 'none';
            }
        }

        // Auto-adjust textarea height
        function adjustTextareaHeight(textarea) {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 100) + 'px';
        }

        // Handle key down
        function handleKeyDown(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        // Toggle emoji picker
        function toggleEmojiPicker() {
            const isVisible = emojiPicker.style.display === 'block';
            emojiPicker.style.display = isVisible ? 'none' : 'block';
        }

        // Handle emoji select
        function handleEmojiSelect(event) {
            messageInput.value += event.detail.unicode;
            emojiPicker.style.display = 'none';
            messageInput.focus();
        }

        // Handle file upload
        function handleFileUpload(event) {
            const files = Array.from(event.target.files);
            selectedFiles = [...selectedFiles, ...files];
            displayFilePreview();
        }

        // Display file preview
        function displayFilePreview() {
            const preview = document.getElementById('filePreview');
            preview.innerHTML = '';

            if (selectedFiles.length > 0) {
                preview.style.display = 'block';

                selectedFiles.forEach((file, index) => {
                    const previewItem = document.createElement('div');
                    previewItem.className = 'file-preview-item';

                    if (file.type.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = URL.createObjectURL(file);
                        img.style.cssText = 'width: 50px; height: 50px; object-fit: cover;';
                        previewItem.appendChild(img);
                    } else {
                        previewItem.innerHTML = `
                                <div class="bg-light p-2 rounded" style="width: 60px; height: 60px;">
                                    <i class="fas fa-file text-muted"></i>
                                    <small class="d-block text-truncate">${file.name}</small>
                                </div>
                            `;
                    }

                    // Add remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'file-preview-remove';
                    removeBtn.innerHTML = '×';
                    removeBtn.onclick = () => removeFile(index);
                    previewItem.appendChild(removeBtn);

                    preview.appendChild(previewItem);
                });
            } else {
                preview.style.display = 'none';
            }
        }

        // Remove file from selection
        function removeFile(index) {
            selectedFiles.splice(index, 1);
            displayFilePreview();
        }

        // Toggle voice recording
        function toggleVoiceRecording() {
            const voiceBtn = document.getElementById('voiceBtn');

            if (!recordingAudio) {
                startVoiceRecording();
                voiceBtn.classList.add('recording');
                voiceBtn.innerHTML = '<i class="fas fa-stop text-white"></i>';
            } else {
                stopVoiceRecording();
                voiceBtn.classList.remove('recording');
                voiceBtn.innerHTML = '<i class="fas fa-microphone text-primary"></i>';
            }
        }

        // Start voice recording
        async function startVoiceRecording() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorder = new MediaRecorder(stream);
                audioChunks = [];

                mediaRecorder.ondataavailable = event => {
                    audioChunks.push(event.data);
                };

                mediaRecorder.onstop = () => {
                    const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                    // You can send this audio blob to server
                    // console.log('Voice message recorded:', audioBlob);
                       recordedAudioBlob = new File([audioBlob], 'voice.wav', { type: 'audio/wav' });
                    //  recordedAudioFile =
                    console.log(recordedAudioBlob);

                    const audioURL = URL.createObjectURL(audioBlob);

                    const previewDiv = document.getElementById('voicePreview');
                    previewDiv.style.display = 'block';
                    previewDiv.innerHTML = `
                        <div class="d-flex align-items-center justify-content-between">
                            <audio controls src="${audioURL}" style="flex:1;"></audio>
                            <div class="ms-2">
                                <button class="btn btn-sm btn-danger" onclick="cancelVoiceMessage()">Xoá</button>
                            </div>
                        </div>
                    `;
                    audioChunks = [];
                };

                mediaRecorder.start();
                recordingAudio = true;
            } catch (error) {
                console.error('Error starting voice recording:', error);
                showToast('Không thể truy cập microphone', 'danger');
            }
        }

        // Stop voice recording
        function stopVoiceRecording() {
            if (mediaRecorder && recordingAudio) {
                mediaRecorder.stop();
                mediaRecorder.stream.getTracks().forEach(track => track.stop());
                recordingAudio = false;
            }
        }
        function cancelVoiceMessage() {
            recordedAudioBlob = null;

            const previewDiv = document.getElementById('voicePreview');
            previewDiv.style.display = 'none';
            previewDiv.innerHTML = '';
        }
        // Format time
        function formatTime(date) {
            return new Date(date).toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        // Send message
        async function sendMessage() {
            const message = messageInput.value.trim();
            const nguoiNhanId = document.getElementById('nguoiNhanId').value;
            console.log(recordedAudioBlob);
            if ((!message && selectedFiles.length === 0 && !recordedAudioBlob) || !nguoiNhanId ) {
                if (!nguoiNhanId) {
                    showToast('Vui lòng chọn người để nhắn tin', 'warning');
                }
                console.log('lỗi');

                return;
            }

            // Create temporary message for immediate display
            // if (message) {
            //     const tempMessage = {
            //         id: Date.now(),
            //         message: message,
            //         content: message,
            //         is_own_message: true,
            //         created_at: formatTime(new Date())
            //     };

            //     addMessageToChat(tempMessage, false, false);
            // }
            // Tạo FormData chứa message + các file đã chọn
            const formData = new FormData();
            formData.append('receiver_id', nguoiNhanId);
            formData.append('message', message);
            if(recordedAudioBlob){
                formData.append('audio', recordedAudioBlob, 'voice.wav');
            }
            selectedFiles.forEach((file, index) => {
                formData.append('files[]', file);
            });
            // for (let pair of formData.entries()) {
            //     console.log(pair[0], pair[1]);
            // }

            console.log(formData);

            // Clear input and files
            messageInput.value = '';
            selectedFiles = [];
            recordedAudioBlob = null;
            displayFilePreview();
            adjustTextareaHeight(messageInput);
            cancelVoiceMessage()
            recordedAudioBlob = null;
            // console.log(recordedAudioBlob);

            // Send to server
            const sentMessage = await sendMessageAPI(formData);
            if (!sentMessage) {
                showToast('Không thể gửi tin nhắn. Vui lòng thử lại.', 'danger');
            }

            // Update chat list
            getChatUsers();
        }

        // Send message API
        async function sendMessageAPI(formData) {
            try {
                const response = await fetch('/api/chat/send', {
                    method: 'POST',
                    headers: {
                        // 'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // console.log('Message sent:', data.data);
                    data.data.forEach(message => {
                        console.log(message);
                        addMessageToChat(message, false, false);
                    });

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

        // Mark all as read
        function markAllAsRead() {
            document.querySelectorAll('.badge-notification').forEach(badge => {
                badge.style.display = 'none';
            });
            showToast('Đã đánh dấu tất cả là đã đọc', 'success');
        }

        // Start video call (placeholder)
        function startVideoCall() {
            showToast('Tính năng gọi video đang phát triển', 'info');
        }

        // Toggle chat info (placeholder)
        function toggleChatInfo() {
            showToast('Thông tin chi tiết đang phát triển', 'info');
        }

        // Get CSRF token
        function getCSRFToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

    </script>

@endsection
