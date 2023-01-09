<?php
namespace App\Extensions\Twig;

use App\Entity\Documento;
use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
class MyExtension extends AbstractExtension
{
    private $log;
    public function getFunctions()
    {
        return [
            new TwigFunction('is_granted_role_list', [$this, 'is_granted_role_list']),
        ];
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
}