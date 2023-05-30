{{$Data.modules.header}}
<body class="page-social">

<div class="wrapper">

    {{$Data.modules.topmenu}}
    {{$Data.modules.bettingmenu}}

    <div class="container">
        <div class="row">
            <div class="col-md-9 messages-wrapper">
                <div class="messages">
                    <div class="messages-sidebar">
                        <div class="search-and-menu">
                            <ul class="nav nav-page nav-social">
                                {{$Data.modules.socialmenu}}
                            </ul>
                            <div class="messages-search">
                                <input type="text" class="input-search" id="friends_for_message" placeholder="Search Friends...">
                                <button class="btn-search glyphicon glyphicon-search"></button>
                            </div>
                            <!-- messages search -->
                        </div>
                        <!-- search-and-menu -->

                        <div class="message-friends">
                            <ul class="nav nav-page nav-social" id="conversationsList"></ul>
                        </div>
                        <!-- message friends -->
                    </div>
                    <!-- messages sidebar -->

                    <div class="messages-content">
                        <div class="conversation">
                            <div class="conversation-item" id="messagesPanel"></div>
                        </div>
                        <!-- conversation -->

                        <div class="block-post">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-12 rel">
                                        <form method="POST" id="sendMessage" onsubmit="Messaging.sendMessage(); return false;">
                                            <input type="text" id="inputMessage" class="form-control input-comment" placeholder="Write a message">
                                            <input type="submit" class="hidden">
                                        </form>
                                    </div>
                                    <!-- col -->
                                </div>
                                <!-- row -->
                            </div>
                            <!-- container fluid -->
                        </div>
                    </div>
                    <!-- messages content -->
                </div>
                <!-- messages -->
            </div>
            <!-- col -->

            <div class="col-md-3 social-matches">
                <div class="heading">
                    <h2>
                        {{$lang_arr.upcoming}}
                    </h2>
                </div>
                <div id="upcoming_widget"></div>
            </div>
        </div>
    </div>

    {{$Data.modules.footer}}

    <script>
        UpcomingsWidget.getData();
        Messaging.openLastConversation();
    </script>



