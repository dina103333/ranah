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
        apiKey: "AIzaSyD5EgGbkFG7YALl-icqfn1iRcx0_YyFdsI",
        authDomain: "rana2-379511.firebaseapp.com",
        databaseURL: "https://rana2-379511-default-rtdb.firebaseio.com",
        projectId: "rana2-379511",
        storageBucket: "rana2-379511.appspot.com",
        messagingSenderId: "563265108519",
        appId: "1:563265108519:web:de6a9330f503d2ea30ac02",
        measurementId: "G-WV9G4V6N6L"
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
                "positionClass": "toast-bottom-left",
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

</script>



