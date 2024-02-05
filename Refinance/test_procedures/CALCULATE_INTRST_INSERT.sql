CREATE DEFINER = 'root'@'localhost'
PROCEDURE test.CALCULATE_INTRST_INSERT(IN REFINANCE_ID INT(5))
PROC_LABEL:
BEGIN

    DECLARE I int;
    DECLARE DONE int;
    DECLARE CREF_AGENCY VARCHAR(100);
    DECLARE CSCHEME varchar(100);
    DECLARE CREFI_DATE DATE;
    DECLARE CINTEREST decimal(20,2);
    DECLARE CAMOUNT decimal(20,2);
    DECLARE CINTRESTPAYDATE date;
    DECLARE CINTRESTPAYPERIOD INT(5);
    DECLARE CFIRST_INSTALLMENT DATE;
    DECLARE CPAYMENT_CYCLE INT(5);
    DECLARE CNO_INSTALLMENTS INT(5);
    DECLARE LASTPRINCIPLEPAYDATE date;
    DECLARE CDIFFDAYS int(5);
    DECLARE CDAILYDATES date;
    DECLARE CINST_AMT decimal(20,2);
    DECLARE COUTSTANDING decimal(20,2);
    DECLARE PREV_DATE date;
    DECLARE PREV_INSTAMT decimal(20,2);
    DECLARE PREV_OUTSTANDING decimal(20,2);
    DECLARE CURR_DATE date;
    DECLARE CURR_INSTAMT decimal(20,2);
    DECLARE CURR_OUTSTANDING decimal(20,2);

    DECLARE CLOSING_DATE date;

    DECLARE CGRAND_INT_AMT decimal(20,2);

    DECLARE TEMPCOUNT int(5);
    DECLARE TEMPINTERESTCOUNT int(5);
    DECLARE LOOPCOUNT int(5);
    DECLARE WHILELOOPCOUNT int(5);

    DECLARE TEMPREFIDATE DATE;

    DECLARE TEMPOUTSTANDING decimal(20,2);

    DECLARE UPDATE_CURSOR CURSOR FOR
     SELECT DAILYDATE,outstanding FROM interest_testing WHERE RefID = REFINANCE_ID ORDER BY dailydate;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET DONE = 1;

        SELECT  REFINANCE_AGENCY,
            SCHEME,
            REFI_DATE,
            INTEREST,
            AMOUNT,
            INTRESTPAYDATE,
            INTRESTPAYPERIOD,
            FIRST_INSTALLMENT,
            PAYMENT_CYCLE,
            NO_INSTALLMENTS 
       INTO CREF_AGENCY,
            CSCHEME,
            CREFI_DATE,
            CINTEREST,
            CAMOUNT,
            CINTRESTPAYDATE,
            CINTRESTPAYPERIOD,
            CFIRST_INSTALLMENT,
            CPAYMENT_CYCLE,
            CNO_INSTALLMENTS
       FROM REFINANCE_TEST 
      WHERE REFID=REFINANCE_ID;

    SET TEMPREFIDATE = CREFI_DATE;
    SET CLOSING_DATE = DATE_ADD(CFIRST_INSTALLMENT,INTERVAL ((CNO_INSTALLMENTS-1)*CPAYMENT_CYCLE) MONTH);

    TRUNCATE TABLE interest_testing;

    WHILE TEMPREFIDATE <= CLOSING_DATE DO

    INSERT INTO interest_testing (RefID,Refinance_agency,Scheme,Interest,dailydate)
         SELECT REFINANCE_ID,CREF_AGENCY,CSCHEME,CINTEREST,TEMPREFIDATE;

        SET TEMPREFIDATE = DATE_ADD(TEMPREFIDATE,INTERVAL 1 DAY);
    END WHILE;

    -- UPDATES OUTSTANDING BEFORE FIRST INSTALLMENT DATE

    UPDATE interest_testing test,refinance_test rt
       SET test.outstanding = rt.Amount
        WHERE test.RefID = rt.RefID
          AND test.dailydate <= rt.IntrestPaydate;

    -- UPDATES OUTSTANDING JOINING INSTALLMENT TABLE

    UPDATE interest_testing it,inst_table it1
       SET it.outstanding=it1.outstanding
     WHERE it.RefID = it1.RefID
          AND it.dailydate = it1.Inst_date;

        -- CURSOR STARTS INSERTS OUTSTANDING
        OPEN UPDATE_CURSOR;
    L1:
        LOOP
            FETCH UPDATE_CURSOR INTO CDAILYDATES,COUTSTANDING;
            IF DONE = 1 THEN
                LEAVE L1;
            END IF;
        IF (COUTSTANDING IS NOT NULL) THEN

            set TEMPOUTSTANDING = COUTSTANDING;

        END IF;

        IF COUTSTANDING IS NULL THEN

            UPDATE interest_testing test SET test.outstanding = TEMPOUTSTANDING WHERE test.dailydate = CDAILYDATES;

        END IF;

        END LOOP L1;
        CLOSE UPDATE_CURSOR;

        UPDATE interest_testing SET INTREST_AMOUNT = (INTEREST*OUTSTANDING/36500);

        INSERT INTO refinance_interest_daywise SELECT * FROM interest_testing;

END