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
    class operacionesBasicas
    {
        public $num1;
        public $num2;

        public function __construct($num1, $num2)
        {
            $this->num1 = $num1;
            $this->num2 = $num2;
        }

        public function suma()
        {
            return $this->num1 + $this->num2;
        }

        public function resta()
        {
            return $this->num1 - $this->num2;
        }

        public function multiplicacion()
        {
            return $this->num1 * $this->num2;
        }

        public function division()
        {
            return $this->num1 / $this->num2;
        }
    }

    $operacion = new operacionesBasicas(10, 20);
    echo $operacion->suma() . "<br>";
    echo $operacion->resta() . "<br>";
    echo $operacion->multiplicacion() . "<br>";
    echo $operacion->division() . "<br><br>";


    //-----------------Strings-----------------
    echo "<h2>STRINGS:</h2>";
    class funcionesTexto
    {
        public $texto;

        public function __construct($texto)
        {
            $this->texto = $texto;
        }

        public function cantidadLetras()
        {
            return strlen($this->texto);
        }

        public function cantidadPalabras()
        {
            return str_word_count($this->texto);
        }

        public function textoReverso()
        {
            return strrev($this->texto);
        }
    }

    $texto = new funcionesTexto("Hola, buenas tardes!!");
    echo $texto->cantidadLetras() . "<br>";
    echo $texto->cantidadPalabras() . "<br>";
    echo $texto->textoReverso() . "<br><br>";


    //-----------------Math-----------------
    echo "<h2>FUNCION MATH:</h2>";
    class funcionesMath
    {
        public $numero;

        public function __construct($numero)
        {
            $this->numero = $numero;
        }

        public function operacionPi()
        {
            return $this->numero[1] * pi();
        }

        public function numeroMenor()
        {
            return min($this->numero);
        }

        public function numeroMayor()
        {
            return max($this->numero);
        }

        public function valorAbsoluto()
        {
            return abs($this->numero[0]);
        }

        public function raiz()
        {
            return sqrt($this->numero[2]);
        }

        public function numeroRandom()
        {
            return rand(0, $this->numero[4]);
        }
    }

    $numero1 = new funcionesMath(array(-8, 10, 147, 6, 78));
    echo $numero1->operacionPi() . "<br>";
    echo $numero1->numeroMenor() . "<br>";
    echo $numero1->numeroMayor() . "<br>";
    echo $numero1->valorAbsoluto() . "<br>";
    echo $numero1->raiz() . "<br>";
    echo $numero1->numeroRandom() . "<br><br>";


    //-----------------Constantes-----------------
    echo "<h2>CONSTANTES:</h2>";
    class constantes
    {
        public $constante;

        public function __construct($constante)
        {
            $this->constante = $constante;
        }

        public function primeroLista()
        {
            return $this->constante . carros[0];
        }
    }

    $constante = new constantes(define("carros", [
        "Kia",
        "BMW",
        "Mercedes"
    ]));
    echo $constante->primeroLista() . "<br><br>";


    //-----------------Arreglos-----------------
    echo "<h2>ARREGLOS:</h2>";
    class arreglos
    {
        public $nombres;
        public $numeros;

        public function __construct($nombres, $numeros)
        {
            $this->nombres = $nombres;
            $this->numeros = $numeros;
        }

        public function tipoVariable()
        {
            return var_dump($this->nombres);
        }

        public function longitudArreglo()
        {
            return count($this->nombres);
        }

        public function llamadoIndice()
        {
            return $this->nombres["Persona1"];
        }
    }

    $arreglos = new arreglos(
        array("Persona1" => "Santiago", "Persona2" => "Camilo", "Persona3" => "Luisa"),
        array(45, 50, 2, 17, 27)
    );
    echo $arreglos->tipoVariable() . "<br>";
    echo $arreglos->longitudArreglo() . "<br>";
    echo $arreglos->llamadoIndice() . "<br><br>";


    //-----------------Condicionales-----------------
    echo "<h2>CONDICIONALES:</h2>";
    class condicionales
    {
        public $edad;
        public $rango;

        public function __construct($edad, $rango)
        {
            $this->edad = $edad;
            $this->rango = $rango;
        }

        public function mayorMenorEdad()
        {
            echo $this->edad . "<br>";
            if ($this->edad >= 18) {
                return "Es mayor de edad";
            } else {
                return "Es menor de edad";
            }
        }

        public function rangoPerteneciente()
        {
            if ($this->rango == "A") {
                return "Su rango es alto";
            } elseif ($this->rango == "B") {
                return "Su rango es medio";
            } else {
                return "Su rango es bajo";
            }
        }
    }

    $condicionales = new condicionales(rand(0, 100), "A");
    echo $condicionales->mayorMenorEdad() . "<br>";
    echo $condicionales->rangoPerteneciente() . "<br><br>";


    //-----------------Switch-----------------
    echo "<h2>SWITCH:</h2>";
    class funcionSwitch
    {
        public $mes;

        public function __construct($mes)
        {
            $this->mes = $mes;
        }

        public function mayorMenorEdad()
        {
            switch ($this->mes) {
                case 1:
                    return "Enero";
                    break;
                case 2:
                    return "Febrero";
                    break;
                case 3:
                    return "Marzo";
                    break;
                case 4:
                    return "Abril";
                    break;
                case 5:
                    return "Mayo";
                    break;

                default:
                    return "Mes inexistente <br>";
                    break;
            }
        }
    }

    $switch = new funcionSwitch(2);
    echo $switch->mayorMenorEdad() . "<br><br>";


    //-----------------Ciclos-----------------
    echo "<h2>CICLOS:</h2>";
    class ciclos
    {
        public $limite;
        public $paises;
        public $ciudades;

        public function __construct($limite, $paises, $ciudades)
        {
            $this->limite = $limite;
            $this->paises = $paises;
            $this->ciudades = $ciudades;
        }

        public function numerosWhile()
        {
            echo "<p>While...</p>";
            $i = 1;
            while ($i <= $this->limite) {
                echo "Numero: $i <br>";
                $i++;
            }
        }

        public function numerosDoWhile()
        {
            echo "<p>Do While...</p>";
            $x = 1;
            do {
                echo "Numero: $x <br>";
                $x++;
            } while ($x <= $this->limite);
        }

        public function numerosFor()
        {
            echo "<p>For...</p>";
            for ($j = 1; $j <= $this->limite; $j++) {
                echo "Numero: $j <br>";
            }
        }

        public function contenidoArregloFor()
        {
            $cantPaises = count($this->paises);
            for ($i = 0; $i < $cantPaises; $i++) {
                echo $this->paises[$i];
                echo "<br>";
            }
        }

        public function contenidoArregloForEach()
        {
            echo "<p>Foreach...</p>";
            foreach ($this->ciudades as $i => $ciudad) {
                echo "<li>$i - $ciudad</li>";
            }
        }
    }

    $ciclos = new ciclos(
        7,
        array("Colombia", "Brasil", "Argentina", "Peru"),
        array("Neiva", "Medellin", "Bogota", "Cali")
    );
    echo $ciclos->numerosWhile() . "<br>";
    echo $ciclos->numerosDoWhile() . "<br>";
    echo $ciclos->numerosFor() . "<br>";
    echo $ciclos->contenidoArregloFor() . "<br>";
    echo $ciclos->contenidoArregloForEach() . "<br><br>";


    //-----------------Funciones-----------------
    echo "<h2>FUNCIONES:</h2>";
    class funciones
    {
        public $nombre;
        public $edad;

        public function __construct($nombre, $edad)
        {
            $this->nombre = $nombre;
            $this->edad = $edad;
        }

        public function nombreEdad()
        {
            return "Bienvenido " . $this->nombre . ", su edad es " . $this->edad . " años";
        }
    }

    $funcion = new funciones("Santiago", 19);
    echo $funcion->nombreEdad() . "<br><br>";

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
    echo $persona1->saludo() . "<br>";
    $persona1 = new Persona("Luisa", "21");
    echo $persona1->saludo() . "<br><br>";

    ?>
</body>

</html>