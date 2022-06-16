<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class Instalador extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando inicia el instalador del blog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!$this->verifica()){
            $rol = $this->creaRol();
            $usuario = $this->creaUsuario();
            $usuario->roles()->attach($rol);
            $this->line('Instalación correcta');
        }else{
            $this->error('Instalación previamente ejecutada');
        }
    }

    private function verifica()
    {
        return Rol::find(1);

    }
    private function creaRol(){
        $rol="Super Administrador";
        return Rol::create([
            'nombre'=>$rol,
            'slug'=>Str::slug($rol,'-')
        ]);
    }

    private function creaUsuario(){
        return Usuario::create([
            'nombre'=> 'Master',
            'email'=> 'rb@rb.com',
            'password' => Hash::make('Rjbm-2310'),
            'estado' => 1
        ]);
    }
}