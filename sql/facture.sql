CREATE VIEW facture AS ( 
    SELECT 
        cli.CodeCli,
        cli.Nom,
        cli.Prenom,
        cli.Quartier,
        co.CodeCompteur,
        co.TypeCompteur,
        co.Pu,re.Valeur,
        re.Date_releve,
        re.Date_presentation,
        re.Date_limite_paiement,
        (co.Pu*re.Valeur) AS Montant,
        p.Etat
    FROM client AS cli, compteur AS co, releve AS re, payer AS p
    WHERE cli.CodeCLi = co.CodeCli 
    AND co.CodeCompteur = re.CodeCompteur
    AND re.CodeReleve = p.CodeReleve
);