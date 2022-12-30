<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sintaxis PHP y sintaxis de clases</title>
</head>

<body>
    <h3>30 de diciembre del 2022</h3>
    <h1>SINTAXIS EN PHP Y SINTAXIS DE CLASES</h1>

    <?php
    //-----------------Variables-----------------
    echo "<h2>VARIABLES:</h2>";
    $texto = "Bienvenido!!";
    $numEntero = 30;
    $numDecimal = 4.5;
    $valorBoolean = true;

    $suma = $numDecimal + $numEntero;
    $resta = $numDecimal - $numEntero;
    $multiplicacion = $numDecimal * $numEntero;
    $division = $numDecimal / $numEntero;

    print $texto . "<br>";
    echo "La suma de los valores es: " . $suma . "<br>";
    echo "La resta de los valores es: " . $resta . "<br>";
    echo "La multiplicacion de los valores es: " . $multiplicacion . "<br>";
    echo "La division de los valores es: " . $division . "<br>";
    var_dump($valorBoolean);

    echo "<br>";
    echo "<br>";

    //-----------------Strings-----------------
    echo "<h2>STRINGS:</h2>";
    $text = "Hola, buenos dias!!";

    echo strlen($text) . "<br>";
    echo str_word_count($text) . "<br>";
    echo strrev($text) . "<br>";

    echo "<br>";
    echo "<br>";

    //-----------------Math-----------------
    echo "<h2>FUNCION MATH:</h2>";
    echo (pi()) . "<br>";
    echo (min(150, 45, 2, 800, -4)) . "<br>";
    echo (max(-8, 10, 147, 6, 78)) . "<br>";
    echo (abs(-14.7)) . "<br>";
    echo (sqrt(50)) . "<br>";
    echo (rand(1, 100)) . "<br>";

    echo "<br>";
    echo "<br>";

    //-----------------Constantes-----------------
    echo "<h2>CONSTANTES:</h2>";
    define("Mensaje", "El dia de hoy empiezo a practicar");
    define("carros", [
        "Kia",
        "BMW",
        "Mercedes"
    ]);
    echo carros[1] . "<br>";
    echo Mensaje . "<br>";

    echo "<br>";
    echo "<br>";

    //-----------------Arreglos-----------------
    echo "<h2>ARREGLOS:</h2>";
    $colores = array("Verde", "Azul", "Amarillo");
    $nombres = array("Persona1" => "Santiago", "Persona2" => "Camilo", "Persona3" => "Luisa");
    $numeros = array(45, 50, 2, 17, 27);

    echo var_dump($colores) . "<br>";
    echo count($nombres) . "<br>";
    echo $colores[2] . "<br>";
    echo $nombres["Persona1"] . "<br>";

    echo "<br>";
    echo "<br>";

    //-----------------Condicionales-----------------
    echo "<h2>CONDICIONALES:</h2>";
    $edad = rand(0, 100);
    echo $edad . "<br>";
    if ($edad >= 18) {
        echo "Es mayor de edad <br>";
    } else {
        echo "Es menor de edad <br>";
    }

    $rango = "B";
    if ($rango == "A") {
        echo "Su rango es alto <br>";
    } elseif ($rango == "B") {
        echo "Su rango es medio <br>";
    } else {
        echo "Su rango es bajo <br>";
    }

    $categoria = ($edad >= 18) ? "Mayor" : "Menor";
    echo $categoria . "<br>";

    echo "<br>";
    echo "<br>";

    //-----------------Switch-----------------
    echo "<h2>SWITCH:</h2>";
    $mes = 2;
    switch ($mes) {
        case 1:
            echo "Enero <br>";
            break;
        case 2:
            echo "Febrero <br>";
            break;
        case 3:
            echo "Marzo <br>";
            break;
        case 4:
            echo "Abril <br>";
            break;
        case 5:
            echo "Mayo <br>";
            break;

        default:
            echo "Mes inexistente <br>";
            break;
    }

    echo "<br>";
    echo "<br>";

    //-----------------Ciclos-----------------
    echo "<h2>CICLOS:</h2>";
    echo "<p>While...</p>";
    $i = 1;
    while ($i <= 7) {
        echo "Numero: $i <br>";
        $i++;
    }

    echo "<br>";
    echo "<br>";

    echo "<p>Do While...</p>";
    $x = 1;
    do {
        echo "Numero: $x <br>";
        $x++;
    } while ($x <= 5);

    echo "<br>";
    echo "<br>";

    echo "<p>For...</p>";
    for ($j = 1; $j <= 4; $j++) {
        echo "Numero: $j <br>";
    }

    echo "<br>";

    $paises = array("Colombia", "Brasil", "Argentina", "Peru");
    $cantPaises = count($paises);
    for ($i = 0; $i < $cantPaises; $i++) {
        echo $paises[$i];
        echo "<br>";
    }

    echo "<br>";
    echo "<br>";

    echo "<p>Foreach...</p>";
    $ciudades = array("Neiva", "Medellin", "Bogota", "Cali");
    foreach ($ciudades as $i => $ciudad) {
        echo "<li>$i - $ciudad</li><br>";
    }

    echo "<br>";
    echo "<br>";

    //-----------------Funciones-----------------
    echo "<h2>FUNCIONES:</h2>";
    function nombreEdad($nombre, $edad)
    {
        echo "Bienvenido $nombre, su edad es $edad años <br>";
    }

    nombreEdad("Santiago", 19);

    function suma($num1, $num2)
    {
        return $num1 + $num2;
    }

    echo suma(12, 28);

    echo "<br>";
    echo "<br>";

    //-----------------Objetos-----------------
    echo "<h2>OBJETOS:</h2>";
    class Persona
    {
        public $nombre;
        public $edad;
        public function __construct($nombre, $edad)
        {
            $this->nombre = $nombre;
            $this->edad = $edad;
        }
        public function saludo()
        {
            return "Hola, soy " . $this->nombre . ", tengo " . $this->edad . " años!!";
        }
    }

    $persona1 = new Persona("Santiago", 19);
    echo $persona1->saludo();
    echo "<br>";
    $persona1 = new Persona("Luisa", "21");
    echo $persona1->saludo();

    ?>
</body>

</html>