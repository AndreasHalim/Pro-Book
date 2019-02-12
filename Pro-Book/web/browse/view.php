<?php

require_once ('../autoload.php');



function viewBrowse (array $params) {
    echo Header::generateHeadWithJS('Browse', 'browse', 'browse');
    echo '<link rel="stylesheet" type="text/css" href="../css/search_result.css">';
    $searchForm = '
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-cookies.min.js"></script>
        <div class="flex-container-search-form orange-text" >
            <label class="search-box-text" >Search Book</label>
        </div>


        <div ng-app="myApp" ng-controller="myCtrl">
            <div class="flex-container-search-form margin-top-bottom-10 add-flex-direction-column">
                <p id="warning-empty-input" class="red-theme alert-box text-size-20 add-nunito-font c-round">Input can\'t be empty</p>
                <input ng-model="inputSearch" ng-keypress="callAngular()" id="inputSearch" class="text-size-20 full-width c-input add-border-gray c-round" type="text" name="search_text" placeholder="Input search terms...">
            </div>
            <div class="load" ng-if="loading"><center><img src="../images/loading.gif"></center></div>
            <div class="rows" ng-if="!loading">
                <div class="title-left">
                    <p class="tRight"> {{ textSearchResult }} <u>{{ inputSearch }}</u> </p>    
                    <p class="tRight"> {{ textFound }} <u>{{ result.jumlahBuku }}</u> {{ unit }} </p>
                </div>
                <div class="main-container" ng-repeat="x in result.buku">
                    <table>
                    <td class="gambar">                
                        <div class="main-left">
                            <img class="pp" src= "{{ x.gambar }}" alt="Profile Picture">
                        </div>
                    </td>
                    <td class="info">
                        <div class="main-right">
                            <h3> {{ x.judul }} </h3>
                            <h4> {{ x.pengarang }} - {{ x.rating }} </h4>
                            <p class="desc"> {{(x.deskripsi | limitTo: 100) + (x.deskripsi.length > 100 ? " ... " : "")}}</p>
                        </div>
                    </td>
                    <td class="tombol">
                        <div class="button_row">
                            <button type="reset" class="add-nunito-font light-blue c-round" ng-click="callBookDetail(x.idBuku, x.pengarang)">Detail</button>
                        </div>
                    </td>
                    </table>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        </div>
        
        <script>
            var app = angular.module("myApp", ["ngCookies"]);
            app.controller("myCtrl", ["$scope", "$cookies", "$cookieStore", "$timeout", "$http", "$window", function($scope, $cookies, $cookieStore, $timeout, $http, $window) {
                $scope.callAngular = function() {
                    $scope.loading = true;
                    $scope.textSearchResult = "Search Result for ";
                    $scope.textFound = "Found ";
                    $scope.unit = " book(s)";
                    $timeout(function() {
                        $http.get("browse/SOAPRequest.php?search_text=" + document.getElementById("inputSearch").value)
                        .then(function(response) {
                            $scope.result = response.data;
                            // $cookies.put("data", response.data);
                            $scope.loading = false;
                        });
                    }, 1000)
                }; 

                $scope.callBookDetail = function(idBuku, pengarang){
                    var url = "book_detail?idBuku=" + idBuku + "&pengarang=" + pengarang;
                    $window.location.href=(url);
                }

            }]);
        </script>
    ';
    Body::outputInBody(
        Header::headerLogin($params['username']).
        Header::headerMenu(Header::BROWSE).
        $searchForm
    );    
}

?>