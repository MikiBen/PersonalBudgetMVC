/**
		* Dodanie bilbioteki jQuery do walidacji hasła
	*/
		$.validator.addMethod('validPassword',
			function(value, element, param){
				if (value != '') {
					if(value.match(/.*[a-z]+.*/i) ==null){
						return false;
					}
					if (value.match(/.*\d+.*/) == null){
						return false;
					}

				}
				return true;
			},
			'Musi zawierać jedną literą i liczbę'
			
			);