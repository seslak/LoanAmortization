<?php
class loan {
    public $K;
    public $n;
    public $p;
    public $t;

    function __construct($K,$n,$p,$t) {
    $this->K = $K;
    $this->n = $n;
    $this->p = $p;
    $this->t = $t;
    $this->r = 1+(($this->p)/($this->t)/100);
    $this->I = pow($this->r,$this->n);
    $this->II = 1/$this->I;
    $this->III = ($this->r*(pow($this->r,$this->n)-1))/(($this->r)-1);
    $this->IV = (pow($this->r,$this->n)-1)/(pow($this->r,$this->n)*(($this->r)-1));
    $this->V = 1/($this->IV);
    $this->a = $this->annuity();
}
    function r() {
        return $this->r;
    }

    function I() {
        return $this->I;
    }

    function II() {
        return $this->II;
    }

   function III() {
        return $this->III;
    }

    function IV() {
        return $this->IV;
    }

    function V() {
        return $this->V;
    } 

    function a($model) {
    if (empty($model)) {
        $this->model = "decursive";
    }
    else { $this->model = $model; }
    $this->a = $this->annuity();
    return $this->a;
    }

    function annuity() {
        if ($this->model == "anticipative") {
           $this->n = ($this->n)-1;
           $this->IV = (pow($this->r,$this->n)-1)/(pow($this->r,$this->n)*(($this->r)-1));
           $x = ($this->K)/(1+($this->IV));
           $this->n = ($this->n)+1;
           $this->IV = (pow($this->r,$this->n)-1)/(pow($this->r,$this->n)*(($this->r)-1));
           return $x;
        }
        if ($this->model == "decursive") {
           return (($this->V)*($this->K));
        }
    }

    function amortization($model) {
        if ($model == "anticipative") {
        $this->model = $model;
        $debt = ($this->K)-($this->a("anticipative"));
        $c = ($this->n)-1;
        $i = 1;
        echo "# &nbsp;&nbsp;&nbsp;&nbsp; Annuity &nbsp;&nbsp;&nbsp;&nbsp; Intrest &nbsp;&nbsp;&nbsp;&nbsp; Debt pay off &nbsp;&nbsp;&nbsp;&nbsp; Rest of debt<br>";
        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
        echo (number_format($this->a("anticipative"),2,',',' ')) . "&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
        echo (number_format($this->a("anticipative"),2,',',' ')) . "&nbsp;&nbsp;&nbsp;&nbsp;";
        echo number_format($debt,2,',',' ');
        echo "<br>";
        while ($i <= $c) {
            echo $i . "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo (number_format($this->a("anticipative"),2,',',' ')) . "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo number_format($debt*$this->p/$this->t/100,2,',',' ') . "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo number_format($this->a("anticipative")-($debt*$this->p/$this->t/100),2,',',' ') . "&nbsp;&nbsp;&nbsp;&nbsp;";
            echo number_format($debt-($this->a("anticipative")-($debt*$this->p/$this->t/100)),2,',',' ') .  "&nbsp;&nbsp;&nbsp;&nbsp;";
            $debt = $debt-($this->a("anticipative")-($debt*$this->p/$this->t/100));
            echo "<br>";
            $i = $i+1;
        }
        }
        if ($model == "decursive") {
        $this->model = $model;
        $debt = ($this->K);
        $c = ($this->n);
        $i = 1;
        echo "# &nbsp;&nbsp;&nbsp;&nbsp; Annuity &nbsp;&nbsp;&nbsp;&nbsp; Intrest &nbsp;&nbsp;&nbsp;&nbsp; Debt pay off &nbsp;&nbsp;&nbsp;&nbsp; Rest of debt<br>";
        echo "<br>";
        while ($i <= $c) {
            echo $i . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo (number_format($this->a("decursive"),2,',',' ')) . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo number_format($debt*$this->p/$this->t/100,2,',',' ') . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo number_format($this->a("decursive")-($debt*$this->p/$this->t/100),2,',',' ') . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo number_format($debt-($this->a("decursive")-($debt*$this->p/$this->t/100)),2,',',' ');
            $debt = $debt-($this->a("decursive")-($debt*$this->p/$this->t/100));
            echo "<br>";
            $i = $i+1;
        }
        }
    }
}
?>