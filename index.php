<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .strokes{width:25px; border:0px}
    </style>
    <title>Hello, world!</title>
  </head>
  <body>

<?php 

include('functions.php');

$hcp = (isset($_POST['hcp']) && is_numeric($_POST['hcp'])) ? $_POST['hcp'] : 0; //usuario
$courseId = (isset($_POST['course']) && ($_POST['course'])) ? $_POST['course'] : ''; //api
$genero = (isset($_POST['genero']) && ($_POST['genero'])) ? $_POST['genero'] : 'men';
$color = (isset($_POST['color']) && ($_POST['color'])) ? $_POST['color'] : 'White';

$porcentaje = 0.95; //stableford
//$hoyos = 18; //campo
$colores = array();
$genders = array('men', 'women');

/*
    $par = 72; //campo
    $vc = 69.7; //campo
    $vs = 117; //campo
    echo ("$porcentaje * ($hcp * $vs/113 + $vc - $par)");
*/

$numHoles = $CalculaHCPJuego = $hcpJuego = $par = $vc = $vs = 0;
if ($courseId):
    $CalculaHCPJuego = new CalculaHCPJuego($hcp, $porcentaje, $genero, $color, $courseId);
    $golpesExtras = $CalculaHCPJuego->golpesExtras();
    $numHoles = $CalculaHCPJuego->getCourseNumHoles();
    $hcpJuego = $CalculaHCPJuego->getHcpJuego();
    $par = $CalculaHCPJuego->getPar();
    $vc = $CalculaHCPJuego->getVC();
    $vs = $CalculaHCPJuego->getVS();

    //printr($courses->getCourses());
    //printr($courses-> getCourse(2));
    //printr($courses->getTeesList(2));
    //printr($courses->getColors(3));
    //printr($courses->getScoreCardDetails(2));

    //printr($CalculaHCPJuego->hcpJuego());
    //printr($CalculaHCPJuego->getCourseById());
    printr($CalculaHCPJuego->getTeesList());
    //printr($CalculaHCPJuego->getTeesListByColor());
    //printr($CalculaHCPJuego->getYdsHole());
    //printr($CalculaHCPJuego->golpesExtras());
    //printr($CalculaHCPJuego->getVC());
    //printr($CalculaHCPJuego->getVS());
    //  printr($CalculaHCPJuego->getPrevScoreCardDetails());
    //printr($CalculaHCPJuego->getScoreCardDetails());
    //printr($CalculaHCPJuego->getHcpHole());
    //printr($CalculaHCPJuego->getParHole());
    //printr($CalculaHCPJuego->getCourseNumHoles());
endif;

$courses = new Courses();

?>
<div class="container">
    <h2>Scorecard</h2>
    <form method="post">
        <div class="row">
            <div class="form-group col-md-2">
                <label for="hcp">Handicap</label>
                <input type="text" class="form-control" id="hcp" name="hcp" placeholder="Enter Handicap" value="<?=$hcp?>">
            </div>
            <div class="form-group col-md-2">
                <label for="exampleFormControlSelect1">Género</label>
                <select class="form-control" id="genero" name="genero">
                    <?php foreach ($genders as $gender): ?>
                        <option id="<?php echo $gender ?>" value="<?php echo $gender ?>" <?php echo ($gender == $genero) ? 'selected' : '' ?>><?php echo $gender ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="_color">Color</label>
                <input type="hidden" class="form-control" id="_color" name="_color" placeholder="Enter Color" value="<?=$color?>" disabled>

                <select class="form-control" id="color" name="color">
                    <?php foreach ($colores as $color): ?>
                        <option id="<?php echo $color ?>" value="<?php echo $color ?>" <?php echo ($color == $color) ? 'selected' : '' ?>><?php echo $color ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleFormControlSelect1">Courses</label>
                <select class="form-control" id="course" name="course">
                    <option value="">(Seleccionar campo...)</option>
                    <?php foreach ($courses->getCourses() as $course): ?>
                        <option id="<?php echo $course['id'] ?>" value="<?php echo $course['id'] ?>" <?php echo $course['id'] == $courseId ? 'selected' : '' ?>><?php echo $course['courseName'] . ' (' . $course['countryFull'] . ')' . ' (' . $course['layoutTotalHoles'] . ' hoyos)' ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mb-2">Run</button>
    </form>
    <br>

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header"><strong>Handicap Juego: </strong></div>
                <div class="card-body"><span id="hcpJuego" data-dato="<?=$hcpJuego?>"><?=$hcpJuego?></span></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header"><strong>Par: </strong></div>
                <div class="card-body"><span id="par" data-dato="<?=$par?>"><?=$par?></span></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header"><strong>VC: </strong></div>
                <div class="card-body"><span id="vc" data-dato="<?=$vc?>"><?=$vc?></span></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header"><strong>VS: </strong></div>
                <div class="card-body"><span id="vs" data-dato="<?=$vs?>"><?=$vs?></span></div>
            </div>
        </div>
    </div>

    <?php if ($courseId): ?>

        <br>

        <div class="row">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <?php for($i = 1; $i <= $numHoles; $i++): ?>
                                <th><?=$i?></th>
                            <?php endfor; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>handicapHoyo</th>
                            <?php foreach ($golpesExtras as $i => $golpesExtra): ?>
                                <td><span id="hcphoyo<?php echo ($i+1)?>" class="hcphoyo" data-dato="<?=$golpesExtra['handicapHoyo'] ?>"><?=$golpesExtra['handicapHoyo'] ?></span></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>parHoyo</th>
                            <?php foreach ($golpesExtras as $i => $golpesExtra): ?>
                                <td><span id="parhoyo<?php echo ($i+1)?>" class="parhoyo" data-dato="<?=$golpesExtra['parHoyo'] ?>"><?=$golpesExtra['parHoyo'] ?></span></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr class="d-none">
                            <th>ydsHole</th>
                            <?php foreach ($golpesExtras as $i => $golpesExtra): ?>
                                <td><?=$golpesExtra['ydsHoyo'] ?></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>golpesExtra</th>
                            <?php foreach ($golpesExtras as $i => $golpesExtra): ?>
                                <td><span id="extra<?php echo ($i+1)?>" class="extra" data-dato="<?=$golpesExtra['golpesExtra'] ?>"><?=$golpesExtra['golpesExtra'] ?></span></td>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <th>STROKES</th>
                            <?php for($i = 1; $i <= $numHoles; $i++): ?>
                                <td><input type="text" class="strokes" data-pos="<?=$i?>" /></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>Netos</th>
                            <?php for($i = 1; $i <= $numHoles; $i++): ?>
                                <td><span id="neto<?=$i?>" class="neto"></span></td>
                            <?php endfor; ?>
                        </tr>
                        <tr>
                            <th>Stableford</th>
                            <?php for($i = 1; $i <= $numHoles; $i++): ?>
                                <td><span id="stableford<?=$i?>" class="stableford"></span></td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
                <button id="calcButton" type="button" class="btn btn-primary mb-2">Calc</button>
            </div>
        </div>
        <div id="calcContent" class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header"><strong>Golpes: </strong></div>
                    <div class="card-body"><span id="golpes">0</span></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header"><strong>Stableford Points Scored: </strong></div>
                    <div class="card-body"><span id="sfps">0</span></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header"><strong>Resultado Bruto Ajustado: </strong></div>
                    <div class="card-body"><span id="rba">0</span></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-header"><strong>Nivel Jugado: </strong></div>
                    <div class="card-body"><span id="nj">0</span></div>
                </div>
            </div>
        </div>
        <br>    

        <?php //printr($_POST); ?>
        <?php //printr($CalculaHCPJuego); ?>

    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function(){
        const hcpJuego = parseInt(document.querySelector("#hcpJuego").getAttribute("data-dato")); //console.log(hcpJuego);
        const par = parseInt(document.querySelector("#par").getAttribute("data-dato")); //console.log(par);
        const vc = parseInt(document.querySelector("#vc").getAttribute("data-dato")); //console.log(vc);
        const vs = parseFloat(document.querySelector("#vs").getAttribute("data-dato")); //console.log(vs);
        const asc = 0;

        $('#course').change(function(){
            if (!$(this).val()){
                return false;
            }

            $.ajax({
                url: "ajax.php",
                method: "GET",
                async: false,
                data: {course: $(this).val()},
                dataType: "json",
                success: function(r) {
                    //console.log(r);
                    var color = $('#color');
                    color.empty();
                    var _color = $('#_color').val();
                    $.each(r, function(i, l){
                        var selected = '';
                        if (l['teeColorName'] == _color){
                            selected = 'selected';
                        }
                        color.append('<option id="'+l['teeColorName']+'" value="'+l['teeColorName']+'" '+selected+'>'+l['gender']+' ' +l['teeColorName']+'</option>')
                    });
                }
            });
        });

        $('#course').trigger("change");

        var puntos = [];
        var strokes = [];

        $('.strokes').change(function(){
            const puntuacion = [{"p":5,"n":"Albatros","c":"red"},{"p":4,"n":"Eagle","c":"limegreen"},{"p":3,"n":"Birdie","c":"dodgerblue"},{"p":2,"n":"Par","c":"white"},{"p":1,"n":"Bogey","c":"lightgrey"},{"p":0,"n":"Doble Bogey","c":"dimgrey"}];
            const position = $(this).data("pos");
            var golpes = parseInt($(this).val()); //console.log(golpes);

            const neto = document.querySelector("#neto"+position);
            const extra = document.querySelector("#extra"+position).getAttribute("data-dato");
            const hcpHoyo = document.querySelector("#hcphoyo"+position).getAttribute("data-dato");
            const parHoyo = document.querySelector("#parhoyo"+position).getAttribute("data-dato");
            const stableford = document.querySelector("#stableford"+position);

            var diferencia = 0;
            if (golpes == "-"){
                neto.innerHTML = golpes;
                golpes = 99;
            }
            else{
                neto.innerHTML = golpes - extra;
            }

            diferencia = golpes - extra - parHoyo;

            var miPuntuacion = 0;
            //console.log(diferencia);

            switch (true) {
                case (diferencia <= -3):
                    miPuntuacion = puntuacion[0];
                    break;
                case (diferencia == -2):
                    miPuntuacion = puntuacion[1];
                    break;
                case (diferencia == -1):
                    miPuntuacion = puntuacion[2];
                    break;
                case (diferencia == 0):
                    miPuntuacion = puntuacion[3];
                    break;
                case (diferencia == 1):
                    miPuntuacion = puntuacion[4];
                    break;
                default:
                    miPuntuacion = puntuacion[5];
                    break;
            }
            stableford.innerHTML = miPuntuacion.p;
            stableford.closest('td').style.backgroundColor = miPuntuacion.c;
            //stableford.style.backgroundColor = miPuntuacion.c;
            puntos[position] = miPuntuacion.p; //console.log(puntos);
            strokes[position] = golpes; //console.log(strokes);

            //var hcpjuego189 = Math.round(hcpjuego * vs9 / 113 + 2 * (vc9 - par9));
            //var rba9 = 2 * par9 + hcpjuego189 + 36 - (stableford9 + 17);
        });

        $('#calcButton').click(function(){
            var golpes = strokes.reduce((a, b) => a + b, 0); //console.log(golpes);
            document.querySelector("#calcContent #golpes").innerHTML = golpes;

            let total = puntos.reduce((a, b) => a + b, 0); //console.log(total);
            document.querySelector("#calcContent #sfps").innerHTML = total;

            var rba = par + hcpJuego + 36 - total; //console.log(rba);
            document.querySelector("#calcContent #rba").innerHTML = rba;

            var nj = Math.round(((rba - vc - asc) * 113 / vs) * 10) / 10;
            document.querySelector("#calcContent #nj").innerHTML = nj;
      });
    });

</script>

</html>