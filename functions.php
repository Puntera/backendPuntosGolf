<?php

class CalculaHCPJuego
{
    protected $hcpJugador;
    protected $par = 0;
    protected $vc; // Valor del Campo - ratingMen
    protected $vs; // Valor de Slope - slopeMen
    protected $porcentaje; // 0.95 stableford
    protected $hcpJuego; // dinámido
    protected $numHoyos; // layoutTotalHoles
    protected $genero;
    protected $color;
    protected $courseId;

    public function __construct ($hcpJugador, $porcentaje, $genero, $color, $courseId){
        $this->hcpJugador = $hcpJugador;
        $this->genero = $genero;
        $this->color = $color;
        $this->courseId = $courseId;
        $this->par = $this->getParTotal();
        $this->vc = $this->getVC();
        $this->vs = $this->getVS();
        $this->porcentaje = $porcentaje;
        $this->numHoyos = $this->getCourseNumHoles();

        $this->hcpJuego();
    }

    public function hcpJuego()
    {
        $hcpJuego = $this->porcentaje * ($this->hcpJugador * $this->vs / 113 + $this->vc - $this->par);
        $this->hcpJuego = intval(round($hcpJuego));
        return $this->hcpJuego;
    }

    public function golpesExtras()
    {
        $goplesExtraMinimoHoyo = intval($this->hcpJuego / $this->numHoyos);
        if ($goplesExtraMinimoHoyo == 0):
            $golpesExtraSobrante = $this->hcpJuego;
        elseif ($goplesExtraMinimoHoyo > 3):
            $goplesExtraMinimoHoyo = 4;
            $golpesExtraSobrante = 0;
        else:
            $golpesExtraSobrante = $this->hcpJuego - ($goplesExtraMinimoHoyo * $this->numHoyos);
        endif;

        foreach ($this->getHcpHole() as $i => $handicapHoyo){
            $golpesExtra = $goplesExtraMinimoHoyo;
            if ($handicapHoyo <= $golpesExtraSobrante):
                $golpesExtra = 1 + $goplesExtraMinimoHoyo;
            endif;  

            $golpesExtras[$i] = array(
                'handicapHoyo' => $handicapHoyo,
                'parHoyo' => $this->getParHole()[$i],
                'ydsHoyo' => $this->getYdsHole()[$i],
                'golpesExtra' => $golpesExtra
            );
        }

        return $golpesExtras;
    }

    public function getCourseById()
    {
        $course = new Courses();
        return $course->getCourse($this->courseId);
    }

    public function getTeesList()
    {
        return json_decode($this->getCourseById()['teesList'])->teesList;
    }
    

    public function getTeesListByColor()
    {
        $teelist = $this->getTeesList();
        $index = array_search($this->color, array_column($teelist, 'teeColorName'));
        return $teelist[$index];
    }

    public function getHcpJuego()
    {
        return $this->hcpJuego;
    }

    public function getPar()
    {
        return $this->par;
    }

    public function getVC()
    {
        if($this->genero == 'men'):
            $field = 'ratingMen';
        elseif($this->genero == 'women'):
            $field = 'ratingWomen';
        endif;

        return $this->getTeesListByColor()->$field;
    }

    public function getVS()
    {
        if($this->genero == 'men'):
            $field = 'slopeMen';
        elseif($this->genero == 'women'):
            $field = 'slopeWomen';
        endif;

        return $this->getTeesListByColor()->$field;
    }

    public function getPrevScoreCardDetails()
    {
        return json_decode($this->getCourseById()['scorecarddetails']);
    }

    public function getScoreCardDetails()
    {
        if($this->genero == 'men'):
            $field = 'menScorecardList';
        elseif($this->genero == 'women'):
            $field = 'wmnScorecardList';
        endif;

        return json_decode($this->getCourseById()['scorecarddetails'])->$field[0];
    }

    public function getHcpHole()
    {
        return $this->getScoreCardDetails()->hcpHole;
    }

    public function getParHole()
    {
        return $this->getScoreCardDetails()->parHole;
    }

    public function getParTotal()
    {
        return isset($this->getScoreCardDetails()->parTotal) ? $this->getScoreCardDetails()->parTotal : 0;
    }

    public function getCourseNumHoles()
    {
        //return $this->getTeesList()->courseNumHoles;
        return $this->getCourseById()['layoutHoles'];
    }

    public function getYdsHole()
    {
        return $this->getTeesListByColor()->ydsHole;
    }

}

class Courses
{
    protected $courses;

    public function __construct()
    {
        
    }

    public function getJson()
    {
        $json = file_get_contents('courses.txt');
        $this->courses = json_decode($json,true);
    }

    public function getCourses()
    {
        $this->getJson();
        return $this->courses;
    }

    public function getCourse($id)
    {
        $courses = $this->getCourses();
        $index = array_search($id, array_column($courses, 'id'));
        //return $index;
        return $courses[$index];
        //return $this->courses[$id];
    }

    public function getTeesList($id)
    {
        return json_decode($this->getCourse($id)['teesList']);
    }

    public function getColors($id)
    {
        $teesList = $this->getTeesList($id)->teesList;
        if ($teesList):
            foreach ($teesList as $i => $tee):
                $colors[$i] = array(
                    'gender' => $tee->gender,
                    'teeColorName' => $tee->teeColorName,
                );
            endforeach;
        endif;

        return $colors;
    }

    public function getScoreCardDetails($id)
    {
        return  json_decode($this->getCourse($id)['scorecarddetails']);
    }
}

function aaaaa()
{
    
}


function printr($v)
{
    echo '<pre>';
    print_r($v);
    echo '</pre>';
}

?>