<?php


class Contacto extends Eloquent{



	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'contactos';
	protected $fillable = array('nombre', 'apellido', 'email', 'creador');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = array('password', 'remember_token');
	public function lugares()
    {
        return $this->belongsToMany('Lugar');
    }

}
