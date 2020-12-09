<!doctype html>
<html lang="en" ng-app="InternetSpeedApp">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Codeigniter 4 CRUD App Example - positronx.io</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
</head>

<body ng-controller="InternetSpeedController">

    <div class="container mt-4">
   
        <?php
     if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
      }
     ?>
        <h2>Internet Speed Calculator</h2>
        <br>
        <h6 id="progress">Click to get your Internet Speed</h6>
        <div class="text-center box" style="margin: 5% auto;">
            <button class="btn btn-primary" ng-click="add()">
                <i class="fa fa-internet-explorer"></i> Start
            </button>
            <button class="btn btn-info" ng-click="refresh()">
                <i class="fa fa-internet-explorer"></i> Refresh
            </button>


        </div>
        <div class="mt-3">
            <table class="table table-bordered" id="users-list">
                <thead>
                    <tr>
                        <th>IP ADDRESS</th>
                        <th>INTERNET SPEED</th>
                        <th>DOWNLOAD SPEED</th>
                        <th>START TIME</th>
                        <th>END TIME</th>
                        <th>DATA RECEIVED</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody>

                    <tr ng-repeat="internet_data in internet_data">

                        <td>{{internet_data.ip_address}}</td>
                        <td>{{internet_data.internet_speed}}</td>
                        <td>{{internet_data.upload_speed}}</td>
                        <td>{{internet_data.start_time | date : 'dd/M/yyyy h:mm a'}}</td>
                        <td>{{internet_data.end_time | date : 'dd/M/yyyy h:mm a'}}</td>
                        <td>{{internet_data.bytes}}</td>
                        <td>
                            <a ng-click="remove(internet_data.id)" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    
    <script>
    var InternetSpeedApp = angular.module('InternetSpeedApp', []);

   
    InternetSpeedApp.controller('InternetSpeedController', function InternetSpeedController($scope, $http) {
        $scope.internet_data = [];

        $http({
            url: 'index.php/list',
            method: 'GET',
        }).then(function(data) {
            $scope.internet_data = data.data;
            console.log(data);
        });

        $scope.remove = function(id) {

            $http({
                url: 'index.php/delete/' + id,
                method: 'GET',
            }).then(function(data) {
                $scope.internet_data = data.data;
                console.log(data);
            });
        };

        $scope.add = function() {
            InitiateSpeedDetection();
        };

        $scope.refresh = function() {
            ShowProgressMessage("Click to get your Internet Speed");
        };

        var imageAddr = "https://homepages.cae.wisc.edu/~ece533/images/airplane.png";
        var downloadSize = 4995374; //bytes

        function ShowProgressMessage(msg) {
            if (console) {
                if (typeof msg == "string") {
                    console.log(msg);
                } else {
                    for (var i = 0; i < msg.length; i++) {
                        console.log(msg[i]);
                    }
                }
            }

            var oProgress = document.getElementById("progress");
            if (oProgress) {
                var actualHTML = (typeof msg == "string") ? msg : msg.join("<br />");
                oProgress.innerHTML = actualHTML;
            }
        }

        function InitiateSpeedDetection() {
            ShowProgressMessage("Checking...");
            window.setTimeout(MeasureConnectionSpeed, 1);
        };

        if (window.addEventListener) {
            window.addEventListener('load', InitiateSpeedDetection, false);
        } else if (window.attachEvent) {
            window.attachEvent('onload', InitiateSpeedDetection);
        }

        function MeasureConnectionSpeed() {
            var startTime, endTime;
            var download = new Image();
            download.onload = function() {
                endTime = (new Date()).getTime();
                showResults();
            }

            download.onerror = function(err, msg) {
                ShowProgressMessage("Invalid image, or error downloading");
            }

            startTime = (new Date()).getTime();
            var cacheBuster = "?nnn=" + startTime;
            download.src = imageAddr + cacheBuster;

            function showResults() {
                var duration = (endTime - startTime) / 1000;
                var bitsLoaded = downloadSize * 8;
                var speedBps = (bitsLoaded / duration).toFixed(2);
                var speedKbps = (speedBps / 1024).toFixed(2);
                var speedMbps = (speedKbps / 1024).toFixed(2);
                ShowProgressMessage([
                    "Your connection speed is:",
                    speedBps + " bps",
                    speedKbps + " kbps",
                    speedMbps + " Mbps"
                ]);
                var ipaddress;
                $.getJSON("https://api.ipify.org/?format=json", function(e) {
                    console.log(e.ip);
                    ipaddress = e.ip;

                        $http({
                            url: 'index.php/add',
                            method: 'POST',
                            data: {
                                'ip_address': ipaddress,
                                'internet_speed': speedMbps + ' Mbps',
                                'upload_speed': speedKbps + ' Kbps',
                                'start_time': startTime,
                                'end_time': endTime,
                                'bytes': speedBps,
                                'duration': duration,
                            },
                        }).then(function(data) {
                            $scope.internet_data = data.data;
                            console.log(data);
                        });
                });


            }
        }
    });
    </script>
</body>

</html>