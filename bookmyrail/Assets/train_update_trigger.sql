
CREATE OR REPLACE FUNCTION put_old_train_data()
  RETURNS TRIGGER 
  LANGUAGE PLPGSQL
  AS
$$
BEGIN
	IF NEW <> OLD THEN
		 INSERT INTO rail_data_schema.old_train_records(train_number,train_source,train_destination,ac_coaches,sleeper_coaches,running,released_for,released_till,updated_on)
		 VALUES(OLD.train_number,OLD.train_source,OLD.train_destination,OLD.ac_coaches,OLD.sleeper_coaches,OLD.running,OLD.released_for, OLD.released_till, CURRENT_DATE);
	END IF;
	RETURN NEW;
END;
$$;
CREATE TRIGGER train_updates
  BEFORE UPDATE
  ON rail_data_schema.trains
  FOR EACH ROW
  EXECUTE PROCEDURE put_old_train_data();
