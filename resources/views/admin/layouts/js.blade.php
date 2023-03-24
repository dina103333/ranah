<script>
    var hostUrl = "/assets/";
</script>
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<script src="/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="/assets/js/custom/widgets.js"></script>
<script src="/assets/js/custom/apps/chat/chat.js"></script>
<script src="/assets/js/custom/modals/create-app.js"></script>
<script src="/assets/js/custom/modals/upgrade-plan.js"></script>


<script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<script src="/assets/js/custom/apps/invoices/create.js"></script>
<script src="/assets/js/jQuery.print.min.js"></script>

<script src="/assets/js/custom/account/settings/signin-methods.js"></script>
<script src="/assets/js/custom/account/settings/profile-details.js"></script>
<script src="/assets/js/custom/account/settings/deactivate-account.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-database.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.17.1/firebase-firestore.js"></script>

<script>
    const firebaseConfig = {
        apiKey: "AIzaSyBJ_4Efr1aDXQUfm7QeIWXn0-Sd8CdhLb4",
        authDomain: "gold-47e14.firebaseapp.com",
        databaseURL: "https://gold-47e14-default-rtdb.firebaseio.com",
        projectId: "gold-47e14",
        storageBucket: "gold-47e14.appspot.com",
        messagingSenderId: "885142091316",
        appId: "1:885142091316:web:56948478446d871e97bc61",
        measurementId: "G-HPCTCVNVXF"
    };
    firebase.initializeApp(firebaseConfig);
</script>


<script type="text/javascript">
    var statistics = firebase.database().ref("notifications/1");
    statistics.on('value', function(snapshot) {
        if (snapshot.val() != 0) {
            const audio = new Audio("{{ url('notify.mp3') }}");
            audio.play();
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "{{ getLocal() == 'ar' ? 'toast-bottom-left' : 'toast-bottom-right' }}",
                "preventDuplicates": false,
                "showDuration": "3000",
                "hideDuration": "1000",
                "timeOut": "50000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr.warning("<a href='{{ url('/admin/orders') }}'>New Notification</a>");
            updatenumber();
            notifications();
        }
    });

    function updatenumber(){
        $.ajax({
            url: "/admin/unread-notification",
            type: 'get',
            data: {
                _method : 'get',
                _token : $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                console.log(res)
                $(".number").html(res);
            }
        });
    }
    function notifications(){
        $.ajax({
            url: "/admin/all-notifications",
            type: 'get',
            data: {
                _method : 'get',
                _token : $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                console.log(res)
                $(".nav-all-notifications").html('');
                if (res.length > 0){
                    let content = ``;
                    $.each(res.reverse() ,function(notificationId , notificationData)){
                        if(isArray(notificationData) && "message" in notificationData){
                            content +=`<div class="d-flex flex-stack py-4">
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-35px me-4">
                                        <span class="symbol-label bg-light-primary">
                                            <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3"
                                                        d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z"
                                                        fill="black" />
                                                    <path
                                                        d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z"
                                                        fill="black" />
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="mb-0 me-2">
                                        <a href="/admin/orders/show/"+${notificationData["id"]}
                                            class="fs-6 text-gray-800 text-hover-primary fw-bolder">
                                            ${notificationData["message"]}
                                        </a>
                                    </div>
                                </div>
                                <span class="badge badge-light fs-8">
                                    ${notificationData["timestamp"]}
                                </span>
                            </div>`
                        }
                    };
                }
                $(".nav-all-notifications").append(content);
            }
        })
    };
</script>



