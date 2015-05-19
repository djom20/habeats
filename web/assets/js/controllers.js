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
                id: 0,
                index: 1,
                name: {
                    title1: 'ensalada',
                    title2: 'de',
                    title3: 'salmón'
                },
                text: 'Remplaza las carnes rojas por el salmón, ya que te ayuda a mantener bien tu colesterol.',
                steps: {
                    step1: 'Hornea el salmón, así es más sano, luego sazónalo con soya y sal si eres hipotenso. Pica la lechuga y el tomate en pequeños pedazos. ',
                    step2: 'Agrega la lechuga y pica en trocitos el tomate.',
                    step3: 'Revuelve todo y añádele aceite de oliva, no vinagreta, estas tienen mucha grasa.',
                    step4: 'Agrégale sal a tu gusto si eres hipertenso poca, y si eres hipotenso un poco más.'
                }
            },
            {
                id: 1,
                index: 2,
                name: {
                    title1: '',
                    title2: 'ensalada',
                    title3: 'mediterránea'
                },
                text: 'El vinagre balsámico ayuda a bajar el colesterol al igual que las almendras, y son buenas para los diabéticos.',
                steps: {
                    step1: 'Mezcla la lechuga con la rúgala y báñalas en aceite de oliva.',
                    step2: 'Raya el queso parmesano o si prefieres también puedes usar queso finesse, bueno para diabéticos.',
                    step3: 'Agrega el queso y las almendras, te ayudan a bajar el colesterol y regularlo.',
                    step4: 'Mezcla todo finalmente, o también puedes agregar pollo a la plancha mucho más sano.'
                }
            },
            {
                id: 2,
                index: 3,
                name: {
                    title1: '',
                    title2: 'ensalada',
                    title3: 'fruto verde'
                },
                text: 'La manzana y la pera son buenas para hipertensos y personas con colesterol alto, y la soya es buena para los hipotensos.',
                steps: {
                    step1: 'Agrégale a la lechuga los trozos de manzana y pera picados.',
                    step2: 'Ralla una zanahoria,  agrega la alfalfa y luego mezcla todo, y si deseas agrégale ajonjolí, bueno para bajar tu colesterol.',
                    step3: 'Pica el cilantro y agrégalo.',
                    step4: 'Por último añade la soya,  si eres hipotenso un poco más  y si eres hipertenso se cuidadoso.'
                }
            },
            {
                id: 3,
                index: 4,
                name: {
                    title1: '',
                    title2: 'ensalada',
                    title3: 'tropical'
                },
                text: 'El aguacate y las almendras ayudan a bajar el colesterol,  y el tomate es bueno para los diabéticos.',
                steps: {
                    step1: 'Agrégale a la lechuga los trozos de tomate, aguacate y albahaca picados.',
                    step2: 'Pica el ajo en pedazos diminutos y añádale aceite de oliva, luego revuelve todo.',
                    step3: 'Pica las almendras y añádelas.',
                    step4: 'Por último échale sal y pimienta a tu gusto, si eres hipertenso no abuses.'
                }
            },
            {
                id: 4,
                index: 5,
                name: {
                    title1: 'ensalada',
                    title2: 'de',
                    title3: 'pollo y espinaca'
                },
                text: 'La espinaca ayuda a bajar el colesterol y es buena para fortalecer la circulación.',
                steps: {
                    step1: 'Cocina la pechuga de pollo y la espinaca. y pícala en pedazos pequeños.',
                    step2: 'Mezcla el pollo y la espinaca con la lechuga.',
                    step3: 'Pica la piña a tu gusto, pero no abuses si sufres de diabetes, añádele el aceite de oliva y mezcla todo.',
                    step4: 'Por último agrega  sal y pimienta a tu gusto, si eres hipertenso ten cuidado y si eres hipotenso ponle más.'
                }
            },
            {
                id: 5,
                index: 6,
                name: {
                    title1: 'ensalada',
                    title2: 'de',
                    title3: 'picatuna'
                },
                text: 'El pimentón ayuda a reducir el riesgo de inflamación a nivel vascular.',
                steps: {
                    step1: 'Agrégale a la lechuga trozos de pimentón rojo.',
                    step2: 'Agrega el atún a la ensalada.',
                    step3: 'Pica el mango a tu gusto, pero se prudente si sufres del azúcar, agrega el aceite de oliva y mezcla todo.',
                    step4: 'Por último agrega sal y pimienta a tu gusto, si eres hipertenso ten cuidado y si eres hipotenso ponle más.'
                }
            }
        ];

        $scope.receta_current = $scope.recetas[0];

        // console.log('recetas', $scope.recetas);
        // console.log('receta actual', $scope.receta_current);

        $scope.change = function(index, step){
            // console.log("index", index);
            // console.log("step", step);
            var max = $scope.recetas.length - 1;

            if(step != null){
                if(step == 'next'){
                    // console.log('next to');
                    // console.log('next to', max);
                    if(index < max){
                        // console.log('normal');
                        // console.log('index to', index + 1);
                        $scope.receta_current = $scope.recetas[index + 1];
                    }else if(index == max){
                        // console.log('initial');
                        $scope.receta_current = $scope.recetas[0];
                    }
                }else if(step == 'prev'){
                    // console.log('prev to');
                    if(index > 0){
                        // console.log('normal');
                        $scope.receta_current = $scope.recetas[index - 1];
                    }else if(index == 0){
                        // console.log('initial');
                        // console.log('initial to', max);
                        $scope.receta_current = $scope.recetas[max];
                    }
                }
            }
        };
    }]
)
.controller('CorazonCuriosoCtrl', ['$scope', '$http', '$location',
    function($scope, $http, $location) {
        console.log("Init Controller CorazonCuriosoCtrl");
        $("#slide1").carousel({
            interval: 50000
        });

        $scope.clickPrev = function(){
            // console.log("Click Prev");
            $("#slide1").carousel('prev');
        };

        $scope.clickNext = function(){
            // console.log("Click Next");
            $("#slide1").carousel('next');
        };
    }]
)
.controller('BuenLatidoCtrl', ['$scope', '$http', '$location',
    function($scope, $http, $location) {
        console.log("Init Controller BuenLatidoCtrl");
        $scope.myUrl = null;

        $scope.sendUrl = function(){
            if($scope.myUrl != null){
                alert('Gracias por Compartir este contenido, pronto lo publicaremos.');
                console.log($scope.myUrl);
                $scope.myUrl = '';
            }else{
                alert('Debe ingresar el contenido antes de enviar');
            }
        };
    }]
);