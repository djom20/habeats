var Appc = angular.module('Controllers', []);

Appc.controller('HomeCtrl', ['$scope', '$http', '$location',
    function($scope, $http, $location) {
        console.log("Init Controller");
    }]
)
.controller('TeQuieroVerdeCtrl', ['$scope', '$http', '$location',
    function($scope, $http, $location) {
        console.log("Init Controller TeQuieroVerdeCtrl");

        $scope.recetas = [
            {
                name: {
                    title1: 'ensalada',
                    title2: 'de',
                    title3: 'salmón'
                },
                text: 'Remplaza las carnes rojas por el salmón, ya que te ayuda a mantener bien tu colesterol.',
                logo: './assets/img/te_quiero_verde/heart.png',
                ingredients: './assets/img/te_quiero_verde/recetas/1/ingredientes.png',
                steps: {
                    step1: 'Pica la lechuga y el tomate en paqueños pedazos.',
                    step2: 'Hornea el salmón, así es más sano, luego pícalo en pequeños pedazos.',
                    step3: 'Agrega aceite de oliva, no vinagreta, estas tienen mucha grasa.',
                    step4: 'Agregale sal a tu gusto si eres hipertenso, poca, y s eres hipotenso un poco más.'
                },
                banners: {
                    banner1: './assets/img/te_quiero_verde/recetas/1/foto1.jpg',
                    banner2: './assets/img/te_quiero_verde/recetas/1/foto1.jpg',
                    banner3: './assets/img/te_quiero_verde/recetas/1/foto1.jpg',
                    banner4: './assets/img/te_quiero_verde/recetas/1/foto1.jpg'
                }
            }
        ];

        $scope.receta_current = $scope.recetas[0];

        console.log('recetas', $scope.recetas);
        console.log('receta actual', $scope.receta_current);
    }]
)
.controller('CorazonCuriosoCtrl', ['$scope', '$http', '$location',
    function($scope, $http, $location) {
        console.log("Init Controller CorazonCuriosoCtrl");
		$("#slide1").carousel({
  			interval: 50000
		});

        $scope.clickPrev = function(){
			console.log("Click Prev");
			$("#slide1").carousel('prev');
        };

        $scope.clickNext = function(){
			console.log("Click Next");
			$("#slide1").carousel('next');
        };
    }]
);