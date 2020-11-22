Admin.controller('bookingController', function ($scope, $http, $timeout, $interval) {
    $scope.bookingArray = {
        "book_type": 'Reserve',
        "people": 1,
        "select_date": today,
        "select_time": "--:--:--",
        "select_table": "--",
        "first_name": "",
        "last_name": "",
        "email": "",
        "usertype": "Guest",
        "contact_no": ""
    };




    $scope.changeWizard = function () {
        if ($scope.bookingArray.select_time != "--:--:--") {


            $('#bookingTab a[href="#nav-table-tab"]').tab('show');

        }
    }


    $scope.changeWizardProfile = function () {

        $('#bookingTab a[href="#nav-profile-tab"]').tab('show');
    }

    $scope.changeWizardTime = function () {

        $('#bookingTab a[href="#nav-datetime-tab"]').tab('show');
    }

    $scope.changeWizardTble = function () {

        $('#bookingTab a[href="#nav-table-tab"]').tab('show');
    }

    $scope.bookType = function (btype) {
        $scope.bookingArray.book_type = btype;
    }


    $scope.selectTable = function (table) {
        $scope.bookingArray.select_table = table;
        $scope.changeWizardProfile();
    }

    $scope.loginNow = function () {
        $scope.initWizard.logincheck = 0;
    }





    $scope.changePeople = function (func) {
        console.log(func)
        if (func == 'plus') {
            $scope.bookingArray.people += 1;
        } else {
            if ($scope.bookingArray.people != 1) {
                $scope.bookingArray.people -= 1;
            }
        }
    }


    $scope.selectTime = function (ttime) {
        $scope.bookingArray.select_time = ttime;
        $scope.changeWizard();
    }

    $scope.continueWithoutLogin = function () {
        $scope.initWizard.logincheck = 2;
    }


    $scope.selectedDate = function (datef) {
        let ssdate = new Date(datef);
        let selectslot = $scope.initWizard.time[$scope.initWizard.selecttime[ssdate.getDay()]];
        let datecheck = moment(datef);
        var dateformated = datecheck.format('YYYY-MM-DD');
        let ttslot = ["00", "30", ];
        let selectTimeSlot = [];
        for (st in selectslot) {
            let tempst = selectslot[st];
            let splittempst = tempst.split(":");
            let ftime = splittempst[0];
            let sufix = splittempst.length == 2 ? splittempst[1] : "PM";
            for (tt in ttslot) {
                let temptt = ttslot[tt];
                let timetemp = (ftime + ":" + temptt + ":" + sufix);
                let stimef = Date.parse(dateformated + " " + timetemp);
                let ntimeft = new Date();
                let ntimef = Date.parse(ntimeft);
                if (ntimef < stimef) {
                    selectTimeSlot.push(timetemp);
                }
                if (sufix == 'AM') {
//                        selectTimeSlot.push(timetemp);
                }

                console.log(selectTimeSlot)

            }
        }
        $scope.initWizard.timeslot = selectTimeSlot;
    }

    $scope.initWizard = {
        "split": ["00", "15", "30", "45"],
        "time": {
            "TS": ['12', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12:AM', '01:AM'],
            "MWS": ['12', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11'],
        },
        "selecttime": {4: "TS", 5: "TS", 6: "TS", 0: "MWS", 1: "MWS", 2: "MWS", 3: "MWS"},
        "timeslot": [],
        "tables": {
            "zone_g": ["ZG1", "ZG2", "ZG3", "ZG4", "ZG5", "ZG6"],
            "zone_f": ["ZF1", "ZF2", "ZF3", "ZF4", "ZF5", "ZF6", "ZF7", "ZF8"],
        },
        "logincheck": 0,
        "login": {"email": "", "password": ""}
    }

    $scope.getLoginDetails = function () {
        var loginurl = baseurl + "Api/loginOperation"
        $http.get(loginurl).then(function (rdata) {
            let userdata = rdata.data;
            if (userdata) {
                $scope.bookingArray.first_name = userdata.first_name;
                $scope.bookingArray.last_name = userdata.last_name;
                $scope.bookingArray.email = userdata.email;
                $scope.bookingArray.contact_no = userdata.contact_no;
                $scope.bookingArray.usertype = userdata.id;
                $scope.initWizard.logincheck = 3;
            }
        })
    }

    $scope.getLoginDetails();


    $scope.loginFunction = function () {
        console.log($scope.initWizard.login)
        var form = new FormData()
        form.append('email', $scope.initWizard.login.email);
        form.append('password', $scope.initWizard.login.password);
        var loginurl = baseurl + "Api/loginOperation"
        $http.post(loginurl, form).then(function (rdata) {
            let userdata = rdata.data;
            $scope.bookingArray.first_name = userdata.first_name;
            $scope.bookingArray.last_name = userdata.last_name;
            $scope.bookingArray.email = userdata.email;
            $scope.bookingArray.contact_no = userdata.contact_no;
            $scope.bookingArray.usertype = userdata.id;
            $scope.initWizard.logincheck = 3;
        })
    }


    $scope.selectedDate(today);
    $scope.initWiz = function (today) {
        $('#datepicker-inline').datepicker({
            format: 'yyyy-mm-dd',
            startDate: today
        }).on("click", function (e) {
            let sdate = ($('#datepicker-inline').datepicker("getDate"));
            $timeout(function () {
                if (sdate) {
                    $scope.selectedDate(sdate);
                    let datecheck = moment(sdate);
                    var dateformated = datecheck.format('YYYY-MM-DD');
                    $scope.bookingArray.select_date = dateformated;
                }
            });
        });
    }

    $timeout(function () {
        $scope.initWiz(today)
    });
})



Admin.controller('inboxController', function ($scope, $http, $timeout, $interval) {
    $scope.inboxdata = {"emaillist": []};
    $scope.getInboxData = function () {
        var inboxOrderMail = rootBaseUrl + "localApi/inboxOrderMaildb";
        $http.get(inboxOrderMail).then(function (rdata) {
            $scope.inboxdata.emaillist = rdata.data;
        })
    }
    $scope.getInboxData();

})

