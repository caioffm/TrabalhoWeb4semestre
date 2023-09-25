//app.js
let app = angular.module('myApp', ['ui.router', 'cp.ngConfirm']);

app.controller('ctrlGlobal', function ($scope, $http, $ngConfirm) {
    //logout
    $scope.logout = function () {
        $ngConfirm({
            title: 'Atenção',
            content: 'Tem certeza que desejar sair do sistema?',
            scope: $scope,
            buttons: {
                not: {
                    text: 'Não',
                    btnClass: 'btn-danger'
                },
                yes: {
                    text: 'Sim',
                    btnClass: 'btn-primary',
                    action: function () {
                        $http.post('./api/login.php?logout')
                            .then(function () {
                                localStorage.removeItem('@token');
                                window.location.href = './';
                            })
                    }
                }
            }
        })
    }
})

app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');

    let token = localStorage.getItem('@token');
    if (token == null && window.location.pathname !== '/sbadmin/CriarConta.html') {
        window.location.href = '/sbadmin/login.html';
    }


    $stateProvider
        .state('home', {
            url: '/',
            template: '<h3>Home</h3>'
        })
        .state('about', {
            url: '/about',
            template: '<h3>About</h3>'
        })
        .state('user', {
            url: '/user',
            templateUrl: './pages/users/grid.html',
            controller: function ($scope, $http, $ngConfirm) {

                //listar dados
                $http.get('./api/users.php?list')
                    .then(function (response) {
                        $scope.grid = response.data;
                    });

                //deletar item
                $scope.del = function (k, i) {

                    $ngConfirm({
                        title: 'Atenção',
                        content: 'Tem certeza que desejar remover este item?',
                        scope: $scope,
                        buttons: {
                            not: {
                                text: 'Não',
                                btnClass: 'btn-danger'
                            },
                            yes: {
                                text: 'Sim',
                                btnClass: 'btn-primary',
                                action: function () {

                                    $scope.grid.splice(k, 1);
                                    $scope.$apply();

                                    $.get('./api/users.php?del=' + i.id)
                                        .then(function () {
                                            $.alert('Registro deletado com sucesso.');
                                        })
                                }
                            }
                        }
                    })
                }

                //função para adicionar e editar dados
                $scope.send = function (k, i) {

                    $scope.item = angular.copy(i);

                    $ngConfirm({
                        title: (k == 'add') ? 'Cadastrar User' : 'Atualizar User',
                        contentUrl: './pages/users/form.html',
                        scope: $scope,
                        typeAnimed: true,
                        closeIcon: true,
                        theme: 'dark',
                        buttons: {
                            yes: {
                                text: (k == 'add') ? 'Salvar' : 'Editar',
                                btnClass: 'btn-primary',
                                action: function (scope, button) {

                                    let ids = (k == 'add') ? '' : '?id=' + i.id;
                                    let data = $scope.item;
                                    $.post('./api/users.php' + ids, data, function (rs) {

                                        $('.msg').text(rs.msg).removeClass('alert-danger');

                                        if (rs.status == 200) {
                                            $('.msg').addClass('alert alert-success');

                                            if (k == 'add') {
                                                console.log($scope.item)
                                                $scope.grid.push($scope.item);
                                            } else {
                                                $scope.grid[k] = $scope.item;
                                            }

                                            $scope.$apply();
                                            setTimeout(function () {
                                                $('.ng-confirm').remove();
                                            }, 1000)

                                        } else {
                                            $('.msg').addClass('alert alert-danger');
                                            return false
                                        }

                                    }, "json");

                                    return false

                                }
                            }
                        }
                    })
                }
            }
        })
        .state('people', {
            url: '/people',
            templateUrl: './pages/peoples/grid.html',

            controller: function ($scope, $http, $ngConfirm) {
                
                //listar dados
                $http.get('./api/peoples.php?list')
                    .then(function (response) {
                        $scope.grid = response.data;
                    });

                //deletar item
                $scope.del = function (k, i) {

                    $ngConfirm({
                        title: 'Atenção',
                        content: 'Tem certeza que desejar remover este item?',
                        scope: $scope,
                        buttons: {
                            not: {
                                text: 'Não',
                                btnClass: 'btn-danger'
                            },
                            yes: {
                                text: 'Sim',
                                btnClass: 'btn-primary',
                                action: function () {

                                    $scope.grid.splice(k, 1);
                                    $scope.$apply();

                                    $.get('./api/peoples.php?del=' + i.id)
                                        .then(function () {
                                            $.alert('Registro deletado com sucesso.');
                                        })
                                }
                            }
                        }
                    })
                }

                //função para adicionar e editar dados
                $scope.send = function (k, i) {

                    $scope.item = angular.copy(i);

                    $ngConfirm({
                        title: (k == 'add') ? 'Cadastrar Pessoa' : 'Atualizar Pessoa',
                        contentUrl: './pages/peoples/form2.html',
                        scope: $scope,
                        typeAnimed: true,
                        closeIcon: true,
                        theme: 'dark', 
                        buttons: {
                            yes: {
                                text: (k == 'add') ? 'Salvar' : 'Editar',
                                btnClass: 'btn-primary',
                                action: function (scope, button) {

                                    let ids = (k == 'add') ? '' : '?id=' + i.id;
                                    let data = $scope.item;
                                    $.post('./api/peoples.php' + ids, data, function (rs) {

                                        console.log('Resposta do servidor:', rs);
                                        console.log($scope.item);

                                        $('.msg').text(rs.msg).removeClass('alert-danger');

                                        if (rs.status == 200) {
                                            $('.msg').addClass('alert alert-success');

                                            if (k == 'add') {
                                                console.log($scope.item)
                                                $scope.grid.push($scope.item);
                                            } else {
                                                $scope.grid[k] = $scope.item;
                                            }

                                            $scope.$apply();
                                            setTimeout(function () {
                                                $('.ng-confirm').remove();
                                            }, 1000)

                                        } else {
                                            $('.msg').addClass('alert alert-danger');
                                            return false
                                        }

                                    }, "json");

                                    return false

                                }
                            }
                        }
                    })
                }
                $scope.item = $scope.item || {};

                $scope.CEPSearch = function() {
                    let cep = $scope.item.cep;
                    if (cep) {
                        const validacep = /^[0-9]{8}$/;
                        if (validacep.test(cep)) {
                            $http.get(`https://viacep.com.br/ws/${cep}/json/`).then(function(response) {
                                $scope.item.address = response.data.logradouro;
                                $scope.item.city = response.data.localidade;
                                $scope.item.state = response.data.uf;
                            });
                        }
                    }
                };
        
                window.CEPReturn = function(dados) {
                    if (!angular.element(document.body).scope()) return;
                    let $scope = angular.element(document.body).scope();
                    $scope.$apply(function () {
                        $scope.item = $scope.item || {}; // garanta que $scope.item está definido
                        $scope.item.address = dados.logradouro;
                        $scope.item.city = dados.localidade;
                        $scope.item.state = dados.uf;
                    });
                };
            }
        })
}]);