<?php

use App\Models\Uf;
use Illuminate\Database\Seeder;

class UfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ufs = array(
            'AC'=>'Acre',
            'AL'=>'Alagoas',
            'AP'=>'Amapá',
            'AM'=>'Amazonas',
            'BA'=>'Bahia',
            'CE'=>'Ceará',
            'DF'=>'Distrito Federal',
            'ES'=>'Espírito Santo',
            'GO'=>'Goiás',
            'MA'=>'Maranhão',
            'MT'=>'Mato Grosso',
            'MS'=>'Mato Grosso do Sul',
            'MG'=>'Minas Gerais',
            'PA'=>'Pará',
            'PB'=>'Paraíba',
            'PR'=>'Paraná',
            'PE'=>'Pernambuco',
            'PI'=>'Piauí',
            'RJ'=>'Rio de Janeiro',
            'RN'=>'Rio Grande do Norte',
            'RS'=>'Rio Grande do Sul',
            'RO'=>'Rondônia',
            'RR'=>'Roraima',
            'SC'=>'Santa Catarina',
            'SP'=>'São Paulo',
            'SE'=>'Sergipe',
            'TO'=>'Tocantins'
            );

        foreach ($ufs as $key => $uf) {
            Uf::create(['uf' => $key, 'name' => $ufs[$key]]);
        }
    }
}
