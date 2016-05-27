insert into Utilisateur values(1,"Bonfils","Adrien","40bd001563085fc35165329ea1ff5c5ecbdbbeef","1994-10-08","14 rue bidon","bonfilsadrien@gmail.com","0325262524",0)

insert into Utilisateur values(2,"Machin","Bidule","40bd001563085fc35165329ea1ff5c5ecbdbbeef","2000-10-08","14 rue bidon","machinbidule@gmail.com","0325262524",0)

insert into Utilisateur values(3,"Ju","Ki","40bd001563085fc35165329ea1ff5c5ecbdbbeef","2000-10-08","14 rue tokyo","juki@gmail.com","0325262524",1)

insert into Droits values(3,1),(0,1),(1,1),(6,1)

insert into Droits values(0,2),(1,2)

insert into Droits values(0,3),(1,3)

insert into Adherent values(1,"1265486325a","2016-05-06",2)

insert into Adherent values(2,"154613488615d","2016-05-06",3)

insert into Competiteur values(1,"/photo/machinbidule.jpg",1,1,1)

insert into Competiteur values(2,"/photo/JuKi.jpg",2,1,1)

insert into Parente values(1,2)

insert into Club_Organisateur values(1,"Club Titi","Monsieur Geal")

insert into Type_Competition values(1,"Championnat de France",false)

insert into Competition values(1,"56 place truc","2017-05-06",null,1,1)

insert into Course values(1,120,true,1,1,4)

insert into Competition values(2,"56 stade bernard","2001-05-06",null,1,1)

insert into Course values(5,120,false,1,2,3)

insert into Objectif values(1,1)

insert into Equipe values(1,"Bidule-Ki",4)

insert into Voyage values(1,"Bus","Aucun",2)

insert into Voyage values(2,"Bus","Aucun",1)

insert into Participe_Competition_Equipe values(1,1,true)

insert into Participant_Equipe values(1,1),(2,1)

insert into Participe_Voyage values(true,2,2,0,null)

insert into Participe_Voyage values(true,2,1,0,null)

insert into Palmares_Competiteur values(1,8,5)

insert into Participe_Competition_Solo values(5,1,true)

insert into Participe_Competition_Equipe values(1,1,false)

insert into Charger values(1,1,1,1)
