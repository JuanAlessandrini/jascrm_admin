<?php
namespace App\Extensions\Twig;

use App\Entity\Document;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\Twig_SimpleFilter;
class MyExtension extends AbstractExtension
{
    private $log;
    public function getFunctions()
    {
        return [
            new TwigFunction('is_granted_role_list', [$this, 'is_granted_role_list']),
            new TwigFunction('view_field', [$this, 'view_field']),
            new TwigFunction('cast_to_array', [$this, 'cast_to_array']),
            new TwigFunction('get_formatted_number', [$this, 'get_formatted_number']),
            // new Twig_SimpleFilter('cast_to_array', array($this, 'cast_to_array')),
            
            
        ];
    }

    public function get_formatted_number( $number)
    {
        setlocale(LC_MONETARY,"en_US");
        return money_format(" %.2n", $number);
    }

    public function is_granted_role_list( $documento, User $usuario)
    {
        $rolesList = $documento['role_upload'];
        if(!$rolesList){
            return true;
        }else{
            $roles = preg_split("/([,])+/", $rolesList);
            foreach ($roles as $rol) {
                $userRoles = $usuario->getRoles();
                foreach ($userRoles as $userRole) {
                    if ($userRole  == ('ROLE_'.$rol)){
                        return true;
                    }
                }
                
            }
        }
        return false;
    }

    public function is_granted_module($user, $module)
    {
        
         $modulos = "";
        $subrol = $user->getSubRol();
        if(in_array("ROLE_SUPERADMIN", $user->getRoles())){
            return true;
        }
        foreach ($subrol->getPermisos() as $permiso) {
            $modulos.= " ".$permiso->getModulo()->getName();
            if (strtoupper($permiso->getModulo()->getName())  == strtoupper($module)){
                return true;
            }
        }
        // throw new \Exception('Chequeando permiso en modulo '.$modulos, 1);
        return false;
    }

    public function view_field(string $field,Document $document)
    {
        
        
        foreach ($document->getTipo()->getFields() as $campo) {
            
            if ($campo->getName() == $field){
                return true;
            }
        }
        // throw new \Exception('Chequeando permiso en modulo '.$modulos, 1);
        return false;
    }

    public function cast_to_array($stdClassObject){
        // $response = json_encode($stdClassObject, true);
        $response = (array)($stdClassObject);
        // $response = json_decode($response);
        return $response;
    }
}