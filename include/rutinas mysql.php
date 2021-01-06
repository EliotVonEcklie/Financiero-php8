DELIMITER //
	CREATE FUNCTION validadcuentascont ( codigo varchar(30) )
	RETURNS varchar(2)
	BEGIN
  		DECLARE resultado varchar(2);
   		IF (EXISTS (SELECT cuentacaja FROM tesoreciboscaja WHERE cuentacaja = codigo)) THEN SET resultado  = 'Si';
		ELSEIF (EXISTS (SELECT cuentabanco FROM tesoreciboscaja WHERE cuentabanco = codigo)) THEN SET resultado  = 'Si';
		ELSEIF (EXISTS (SELECT cuenta FROM comprobante_det WHERE cuenta = codigo)) THEN SET resultado  = 'Si';
		ELSEIF (EXISTS (SELECT cuenta FROM pptocuentaspptoinicial WHERE cuenta = codigo)) THEN SET resultado  = 'Si';
   		ELSE SET resultado  = 'No';
   		END IF;
   		RETURN resultado ;
	END; //
DELIMITER ;