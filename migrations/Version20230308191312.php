<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration=> Please modify to your needs!
 */
final class Version20230308191312 extends AbstractMigration
{
    public function getDescription():string
    {
        return '';
    }

    public function up(Schema $schema):void
    {
        $bancos = [["name"=>"AMERICAN EXPRESS BANK LTD. SOCIEDAD ANON"],
        ["name"=>"BACS BANCO DE CREDITO Y SECURITIZACION S"],
        ["name"=>"BANCO BICA S.A."],
        ["name"=>"BANCO BRADESCO ARGENTINA S.A."],
        ["name"=>"BANCO CETELEM ARGENTINA S.A."],
        ["name"=>"BANCO CMF S.A."],
        ["name"=>"BANCO COLUMBIA S.A."],
        ["name"=>"BANCO COMAFI SOCIEDAD ANONIMA"],
        ["name"=>"BANCO CREDICOOP COOPERATIVO LIMITADO"],
        ["name"=>"BANCO DE CORRIENTES S.A."],
        ["name"=>"BANCO DE FORMOSA S.A."],
        ["name"=>"BANCO DE GALICIA Y BUENOS AIRES S.A."],
        ["name"=>"BANCO DE INVERSION Y COMERCIO EXTERIOR S"],
        ["name"=>"BANCO DE LA CIUDAD DE BUENOS AIRES"],
        ["name"=>"BANCO DE LA NACION ARGENTINA"],
        ["name"=>"BANCO DE LA PAMPA SOCIEDAD DE ECONOM\u00cdA M"],
        ["name"=>"BANCO DE LA PROVINCIA DE BUENOS AIRES"],
        ["name"=>"BANCO DE LA PROVINCIA DE CORDOBA S.A."],
        ["name"=>"BANCO DE LA REPUBLICA ORIENTAL DEL URUGU"],
        ["name"=>"BANCO DE SAN JUAN S.A."],
        ["name"=>"BANCO DE SANTA CRUZ S.A."],
        ["name"=>"BANCO DE SANTIAGO DEL ESTERO S.A."],
        ["name"=>"BANCO DE SERVICIOS FINANCIEROS S.A."],
        ["name"=>"BANCO DE SERVICIOS Y TRANSACCIONES S.A."],
        ["name"=>"BANCO DE VALORES S.A."],
        ["name"=>"BANCO DEL CHUBUT S.A."],
        ["name"=>"BANCO DEL SOL S.A."],
        ["name"=>"BANCO DEL TUCUMAN S.A."],
        ["name"=>"BANCO DO BRASIL S.A."],
        ["name"=>"BANCO FINANSUR S.A."],
        ["name"=>"BANCO HIPOTECARIO S.A."],
        ["name"=>"BANCO INDUSTRIAL S.A."],
        ["name"=>"BANCO INTERFINANZAS S.A."],
        ["name"=>"BANCO ITAU ARGENTINA S.A."],
        ["name"=>"BANCO JULIO SOCIEDAD ANONIMA"],
        ["name"=>"BANCO MACRO S.A."],
        ["name"=>"BANCO MARIVA S.A."],
        ["name"=>"BANCO MASVENTAS S.A."],
        ["name"=>"BANCO MERIDIAN S.A."],
        ["name"=>"BANCO MUNICIPAL DE ROSARIO"],
        ["name"=>"BANCO PATAGONIA S.A."],
        ["name"=>"BANCO PIANO S.A."],
        ["name"=>"BANCO PRIVADO DE INVERSIONES SOCIEDAD AN"],
        ["name"=>"BANCO PROVINCIA DE TIERRA DEL FUEGO"],
        ["name"=>"BANCO PROVINCIA DEL NEUQU\u00c9N SOCIEDAD AN\u00d3"],
        ["name"=>"BANCO ROELA S.A."],
        ["name"=>"BANCO SAENZ S.A."],
        ["name"=>"BANCO SANTANDER RIO S.A."],
        ["name"=>"BANCO SUPERVIELLE S.A."],
        ["name"=>"BANK OF AMERICA, NATIONAL ASSOCIATION"],
        ["name"=>"BBVA BANCO FRANCES S.A."],
        ["name"=>"BNP PARIBAS"],
        ["name"=>"CAJA DE CREDITO \"CUENCA\" COOPERATIVA LIM"],
        ["name"=>"CAJA DE CREDITO COOPERATIVA LA CAPITAL D"],
        ["name"=>"CITIBANK N.A."],
        ["name"=>"COMPA\u00d1IA FINANCIERA ARGENTINA S.A."],
        ["name"=>"CORDIAL COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"DEUTSCHE BANK S.A."],
        ["name"=>"FIAT CREDITO COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"FORD CREDIT COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"GPAT COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"HSBC BANK ARGENTINA S.A."],
        ["name"=>"INDUSTRIAL AND COMMERCIAL BANK OF CHINA"],
        ["name"=>"JOHN DEERE CREDIT COMPA\u00d1\u00cdA FINANCIERA S."],
        ["name"=>"JPMORGAN CHASE BANK, NATIONAL ASSOCIATIO"],
        ["name"=>"MBA LAZARD BANCO DE INVERSIONES S. A."],
        ["name"=>"MERCEDES-BENZ COMPA\u00d1IA FINANCIERA ARGENT"],
        ["name"=>"METROPOLIS COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"MONTEMAR COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"MULTIFINANZAS COMPA\u00d1IA FINANCIERA S.A."],
        ["name"=>"NUEVO BANCO DE ENTRE R\u00cdOS S.A."],
        ["name"=>"NUEVO BANCO DE LA RIOJA SOCIEDAD ANONIMA"],
        ["name"=>"NUEVO BANCO DE SANTA FE SOCIEDAD ANONIMA"],
        ["name"=>"NUEVO BANCO DEL CHACO S. A."],
        ["name"=>"PSA FINANCE ARGENTINA COMPA\u00d1\u00cdA FINANCIER"],
        ["name"=>"RCI BANQUE S.A."],
        ["name"=>"ROMBO COMPA\u00d1\u00cdA FINANCIERA S.A."],
        ["name"=>"THE BANK OF TOKYO-MITSUBISHI UFJ, LTD."],
        ["name"=>"THE ROYAL BANK OF SCOTLAND N.V."],
        ["name"=>"TOYOTA COMPA\u00d1\u00cdA FINANCIERA DE ARGENTINA"],
        ["name"=>"VOLKSWAGEN CREDIT COMPA\u00d1\u00cdA FINANCIERA S."]];
        // this up() migration is auto-generated, please modify it to your needs

        foreach ($bancos as $banco) {
            
            $this->addSql("INSERT INTO `bank` (`name`) VALUES(:name)", $banco);
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
