<?php


class Lugar extends Eloquent{



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'lugar';
	protected $fillable = array('nombre', 'creador', 'descripcion', 'latitud', 'longitud', 'privacidad', 'categoria');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	public function compartidos()
    {
        return $this->belongsToMany('Contacto');
    }

}
