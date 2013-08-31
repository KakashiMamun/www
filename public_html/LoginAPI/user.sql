USE loginAPI;

CREATE TABLE user
(
    user_id BIGINT UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(10) NOT NULL UNIQUE,
    password VARCHAR(36) NOT NULL,
    class ENUM('Admin', 'Manager', 'Director', 'Accountant','Employee', 'Contact') NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    remember_time INT
);

INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("1","Employee","OET69PAY7OD","1","Wang","luctus.felis.purus@inmolestietortor.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("2","Director","GMM88IUH8YB","6","Steel","sed.libero@Crasvehiculaaliquet.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("3","Accountant","UKE36NUZ7GL","6","Baker","semper.et.lacinia@atiaculis.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("4","Contact","YMW89YUV7EA","1","Richard","Nam.nulla@diamluctuslobortis.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("5","Contact","ORM98QAO5MK","5","Gareth","diam.luctus@Nam.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("6","Accountant","BAD38IIA8ZM","9","Reuben","senectus@metusAenean.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("7","Manager","YFV13CXL1XO","5","Orlando","feugiat.Sed.nec@nuncnullavulputate.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("8","Contact","YYT70MWL3CG","6","Isaac","magna.sed@aliquetmolestietellus.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("9","Accountant","WCL06ZJD9IX","7","Gannon","natoque.penatibus@vulputateduinec.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("10","Accountant","AYE48HWO1YZ","3","Malachi","ante.Nunc.mauris@vulputatenisisem.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("11","Accountant","CUR10UQW7OA","3","Guy","nunc@interdumSedauctor.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("12","Manager","NVD13LFL5AD","8","Benedict","Sed.diam.lorem@montesnasceturridiculus.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("13","Accountant","ITC24VES3AW","6","Garrett","dui@laciniamattisInteger.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("14","Admin","VOV85EDO4XR","8","Ezekiel","mattis.velit@non.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("15","Accountant","EZW14TAJ5PF","4","Berk","ridiculus.mus@sitamet.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("16","Admin","VRM70UWE9VB","2","Erasmus","lorem.vitae.odio@atvelitPellentesque.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("17","Manager","MER88LQJ2HV","10","Emery","in.cursus@magnatellus.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("18","Employee","TRO64KAR8FJ","7","Zeph","Morbi.sit.amet@ametrisus.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("19","Employee","LLR91SIZ4AN","2","Hasad","nec.malesuada.ut@eget.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("20","Employee","SKJ94HSL6DC","7","Declan","elit.Curabitur.sed@egestas.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("21","Admin","OLA09KJR1TA","1","Connor","posuere@necimperdietnec.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("22","Contact","KWR13DVY7HY","8","Chadwick","dolor.vitae@Donecfelisorci.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("23","Manager","UCB57FCL6YC","8","Dane","suscipit@elit.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("24","Employee","XYS73VXO6AQ","2","Phelan","aptent.taciti.sociosqu@interdum.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("25","Admin","RMS82THB6GU","5","Leroy","pharetra.Quisque@Fusce.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("26","Accountant","HDW53IDE0QW","9","Sean","Donec.est@lectuspedeultrices.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("27","Director","EPL09NRQ8UM","5","Brian","fringilla.euismod.enim@lorem.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("28","Employee","YCE68EAY3PJ","4","Kaseem","et.malesuada.fames@consectetuer.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("29","Employee","HIU49UGU7IZ","4","Carlos","Sed@Cras.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("30","Accountant","RBW31WVU1DP","7","Bruce","pede.sagittis@enimnonnisi.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("31","Employee","LQT95HHP9IM","4","Jameson","mauris.rhoncus@gravida.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("32","Director","JJD28MJQ9AJ","9","Lester","mauris.rhoncus@eu.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("33","Manager","HPJ17ULR1VU","5","Lee","feugiat@augue.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("34","Contact","SXR48RNX9CH","2","Ray","justo@Duissit.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("35","Employee","GSJ87WEY5BQ","1","Timothy","sagittis@diameudolor.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("36","Director","XKK10LRP7JZ","6","Bert","nunc.interdum.feugiat@facilisis.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("37","Admin","OEP65BVO9FZ","1","Eaton","erat.eget@dictumsapienAenean.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("38","Manager","HEI96BXP6CF","3","Magee","enim@risus.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("39","Accountant","OTE44KFZ6KI","6","Abbot","tellus.Aenean@urnaUt.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("40","Contact","LGT65JHP9BU","5","Jordan","pede@mieleifend.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("41","Employee","PHM46RLA1ST","8","Dante","accumsan@Naminterdumenim.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("42","Manager","EQD00EHY7OL","2","Carter","id@Proin.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("43","Manager","MEE16VYV9PY","10","Luke","molestie@sitamet.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("44","Director","GKA24PIM0NR","3","Chaim","vitae.aliquam@esttemporbibendum.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("45","Employee","ZXP09QEQ8OR","1","Xavier","velit@Pellentesqueultricies.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("46","Accountant","BAL04VBF8ZU","9","Vernon","erat.semper@nonsapien.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("47","Admin","BWQ14STC7UO","8","Dante","habitant.morbi@primisin.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("48","Director","IYS53HBB3XR","6","Elmo","torquent.per@purusgravida.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("49","Contact","UQP07JRV7QO","3","Vincent","euismod.urna.Nullam@Maurisnondui.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("50","Contact","BFB01JLY1BO","2","Prescott","egestas.Aliquam.fringilla@bibendumfermentum.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("51","Accountant","LGO19EEZ2JA","3","Jonah","lobortis.ultrices@vulputatemauris.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("52","Employee","DRB36MJX9QM","1","Logan","sem.molestie@ametmetus.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("53","Director","OPP62CQV2HX","6","Sylvester","non.lobortis@utquamvel.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("54","Employee","WUZ59BOT6EI","3","Holmes","neque.non@natoque.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("55","Director","UVU00AYO8SN","4","Lev","arcu.Sed@ataugue.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("56","Manager","XUJ00JQF1LA","2","Kadeem","cursus@neque.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("57","Contact","VJK47ZPA8JJ","10","Gage","nulla.Donec.non@tinciduntnibh.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("58","Manager","SPZ38LMD2VO","8","Kuame","non.feugiat@nuncrisus.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("59","Manager","QPC26SYU3NU","8","Giacomo","lorem@Sedauctor.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("60","Accountant","GBE24FYM8NO","2","Burke","egestas@Aeneansedpede.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("61","Admin","NJP55GFB4HF","8","Plato","tellus.Phasellus@velit.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("62","Accountant","FTY91XWR4FH","1","Price","cubilia.Curae@convallisconvallisdolor.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("63","Director","OSM30UML9GK","10","Fitzgerald","ligula@tincidunt.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("64","Admin","PXM66UDZ3VM","8","Thane","primis@vitaeposuere.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("65","Director","WVY25SCN3ZA","10","Lionel","odio.Nam.interdum@augueid.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("66","Director","EPP97LAS3VQ","6","Garrison","ac.facilisis@Suspendissetristiqueneque.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("67","Employee","WYQ98LHA5XQ","6","Marvin","mus@felisullamcorper.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("68","Accountant","RAB56HJJ1IZ","2","Carl","dolor.elit@feugiat.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("69","Manager","JGJ41CUO7VQ","4","Herrod","et.ultrices.posuere@risusDonecegestas.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("70","Director","KDY26YCR3IB","8","Hall","nascetur@ornarelectusante.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("71","Director","PRB38HNN6RM","9","Elliott","Lorem.ipsum@Nullasempertellus.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("72","Manager","SDJ34DYL7QN","1","Jameson","faucibus.leo.in@lectus.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("73","Employee","PRQ61JVF1YO","5","Gabriel","faucibus.lectus.a@diamvelarcu.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("74","Contact","OOK09ZZH5RX","3","Steel","vitae@Suspendisse.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("75","Director","FVI53VQL3EW","5","Blaze","Nunc.laoreet.lectus@orciin.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("76","Admin","BAT79DCE3XM","9","Clayton","hendrerit.neque@Vestibulumante.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("77","Employee","EUS44RCE7CX","5","Adam","semper@Maecenas.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("78","Accountant","GTJ79EDN3XF","9","Fletcher","massa.Vestibulum.accumsan@cursuset.edu");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("79","Contact","GVW90MZT7SD","5","Malachi","urna@tristique.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("80","Manager","KWK88LIJ6DG","7","Carl","dictum.magna.Ut@utodiovel.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("81","Contact","EAC55ZVX4SH","3","Kenneth","et.ipsum.cursus@orciinconsequat.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("82","Employee","UIZ82YFV1GY","7","Patrick","vel.nisl.Quisque@Quisqueporttitor.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("83","Manager","UDV91RWV4FV","4","Ivor","et.ipsum.cursus@lectus.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("84","Contact","FLI10DWD9ZY","9","Carlos","Suspendisse.sagittis@sit.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("85","Admin","UMV00JFD6RM","8","Maxwell","augue.eu@idmagnaet.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("86","Contact","UME69QGX4SS","5","Quinn","nec@auctorvelitAliquam.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("87","Manager","VPR50MZH2LL","10","Evan","leo@gravida.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("88","Accountant","PSZ01ABG8RY","5","Orson","nulla.Integer@nisi.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("89","Employee","KBQ30IKS9DR","10","Drew","enim.nisl.elementum@idblandit.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("90","Contact","LQC82GLA6NR","1","Jordan","leo.Cras.vehicula@commodo.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("91","Admin","KCM90XWI3ML","3","Oren","sociis.natoque.penatibus@scelerisquenequeNullam.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("92","Admin","YGJ80FMW5OI","6","Len","viverra@commodohendreritDonec.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("93","Manager","JNR79JDT3KC","2","Hyatt","nascetur@enimCurabitur.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("94","Admin","UMQ22FIU5VL","4","Patrick","felis.Donec.tempor@semperNam.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("95","Admin","SVF32AHB8UR","1","Asher","euismod.urna.Nullam@loremipsumsodales.com");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("96","Contact","LFF05PAM2VR","7","Bevis","nec.euismod.in@Integer.net");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("97","Admin","RFD90CAI5GN","7","Phelan","tellus@velit.org");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("98","Manager","SGV58RHU3MY","3","James","lectus@Crasegetnisi.ca");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("99","Employee","OVG59WFZ5LV","2","Derek","sed.est@mauris.co.uk");
INSERT INTO `user` (`user_id`,`class`,`password`,`remember_time`,`user_name`,`email`) VALUES ("100","Accountant","GOY57GAN8WU","4","Rahim","eget.nisi@anteipsumprimis.edu");












