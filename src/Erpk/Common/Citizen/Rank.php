<?php
namespace Erpk\Common\Citizen;

class Rank
{
    protected $points;
    protected $image;
    protected $name;
    protected $level;
    protected static $ranks = array(
        'Recruit'=>0,
        
        'Private'=>15,
        'Private*'=>45,
        'Private**'=>80,
        'Private***'=>120,
        
        'Corporal'=>170,
        'Corporal*'=>250,
        'Corporal**'=>350,
        'Corporal***'=>450,
        
        'Sergeant'=>600,
        'Sergeant*'=>800,
        'Sergeant**'=>1000,
        'Sergeant***'=>1400,
        
        'Lieutenant'=>1850,
        'Lieutenant*'=>2350,
        'Lieutenant**'=>3000,
        'Lieutenant***'=>3750,
        
        'Captain'=>5000,
        'Captain*'=>6500,
        'Captain**'=>9000,
        'Captain***'=>12000,
        
        'Major'=>15500,
        'Major*'=>20000,
        'Major**'=>25000,
        'Major***'=>31000,
        
        'Commander'=>40000,
        'Commander*'=>52000,
        'Commander**'=>67000,
        'Commander***'=>85000,
        
        'Lt. Colonel'=>110000,
        'Lt. Colonel*'=>140000,
        'Lt. Colonel**'=>180000,
        'Lt. Colonel***'=>225000,
        
        'Colonel'=>285000,
        'Colonel*'=>355000,
        'Colonel**'=>435000,
        'Colonel***'=>540000,
        
        'General'=>660000,
        'General*'=>800000,
        'General**'=>950000,
        'General***'=>1140000,
        
        'Field Marshal'=>1350000,
        'Field Marshal*'=>1600000,
        'Field Marshal**'=>1875000,
        'Field Marshal***'=>2185000,
        
        'Supreme Marshal'=>2550000,
        'Supreme Marshal*'=>3000000,
        'Supreme Marshal**'=>3500000,
        'Supreme Marshal***'=>4150000,
        
        'National Force'=>4900000,
        'National Force*'=>5800000,
        'National Force**'=>7000000,
        'National Force***'=>9000000,
        
        'World Class Force'=>11500000,
        'World Class Force*'=>14500000,
        'World Class Force**'=>18000000,
        'World Class Force***'=>22000000,
        
        'Legendary Force'=>26500000,
        'Legendary Force*'=>31500000,
        'Legendary Force**'=>37000000,
        'Legendary Force***'=>43000000,
        
        'God of War'=>50000000,
        'God of War*'=>100000000,
        'God of War**'=>200000000,
        'God of War***'=>500000000,

        '?' => 90000000000
    );
    
    public function __construct($points)
    {
        $this->points = $points;
        
        $level = count(self::$ranks);
        foreach (array_reverse(self::$ranks) as $name => $p) {
            if ($points >= $p) {
                $this->name = $name;
                $this->level = $level;
                break;
            }
            $level--;
        }
    }
    
    public function getPoints()
    {
        return $this->points;
    }
    
    public function getLevel()
    {
        return $this->level;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getImage()
    {
        $name = $this->name;
        $n = substr_count($name, '*');
        $name = strtr($name, array(' '=>'_', '*'=>'', '.'=>''));
        return
            'http://www.erepublik.com/images/modules/ranks/'.
            strtolower($name).'_'.$n.'.png';
    }
    
    public function getPointsToAdvance()
    {
        $ranks = array_values(self::$ranks);
        return $ranks[$this->level] - $this->points;
    }

    public function toArray()
    {
        return array(
            'name' => $this->getName(),
            'level' =>  $this->getLevel(),
            'points' =>  $this->getPoints(),
            'image' => $this->getImage(),
            'toNext' => $this->getPointsToAdvance()
        );
    }
}
