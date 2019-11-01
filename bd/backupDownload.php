<?php
    /*insert into Measure (date, meterNumber, value, account_id, plant_id, point_id, meter_id) values (.......)

    date = data/hora da leitura
    meterNumber = número do medidor
    value = valor da leitura
    account_id = id da conta
    plant_id = id do condominio
    point_id = id do ponto de leitura
    meter_id = id do medidor
    
    Exemplo do registro mais recente nesta tabela:
    
    id: 12995378
    date: 2019-10-29 18:49:43
    meterNumber: NULL
    value: 24
    account_id: 7				(Villa Lobos) 
    plant_id: 6				(Villa Lobos Torre E)
    point_id: 731				(remota 12 / ponto 15)
    meter_id: 348402			(medidor HTE1016)*/
    //Essa funcao foi criada para criar um backup das leituras em txt no formato aceito pelo banco principal

    include_once("../conexao.php");

    //account_id => id do grupo
    $account_id = 18; //Grupo ISF
    //plant_id => id da planta
    $plant_id = 47; //ISF Alabama
    //point_id => id das unidades
    $point_id = array(
        array(7282,"T6-11",0), array(7276,"T6-11",2), array(7280,"T6-12",0), array(7289,"T6-12",2), 
        array(7274,"T6-13",0), array(7279,"T6-13",2), array(7288,"T6-14",0), array(7275,"T6-14",2), 
        array(7286,"T6-21",0), array(7281,"T6-21",2), array(7287,"T6-22",0), array(7283,"T6-22",2), 
        array(7277,"T6-23",0), array(7285,"T6-23",2), array(7278,"T6-24",0), array(7284,"T6-24",2), 
        array(7298,"T6-15",0), array(7292,"T6-15",2), array(7296,"T6-16",0), array(7305,"T6-16",2), 
        array(7290,"T6-17",0), array(7295,"T6-17",2), array(7304,"T6-18",0), array(7291,"T6-18",2), 
        array(7302,"T6-25",0), array(7297,"T6-25",2), array(7303,"T6-26",0), array(7299,"T6-26",2), 
        array(7293,"T6-27",0), array(7301,"T6-27",2), array(7294,"T6-28",0), array(7300,"T6-28",2), 
        array(7314,"T6-31",0), array(7308,"T6-31",2), array(7312,"T6-32",0), array(7321,"T6-32",2), 
        array(7306,"T6-33",0), array(7311,"T6-33",2), array(7320,"T6-34",0), array(7307,"T6-34",2), 
        array(7318,"T6-41",0), array(7313,"T6-41",2), array(7319,"T6-42",0), array(7315,"T6-42",2), 
        array(7309,"T6-43",0), array(7317,"T6-43",2), array(7310,"T6-44",0), array(7316,"T6-44",2), 
        array(7330,"T6-35",0), array(7324,"T6-35",2), array(7328,"T6-36",0), array(7337,"T6-36",2), 
        array(7322,"T6-37",0), array(7327,"T6-37",2), array(7336,"T6-38",0), array(7323,"T6-38",2), 
        array(7334,"T6-45",0), array(7329,"T6-45",2), array(7335,"T6-46",0), array(7331,"T6-46",2), 
        array(7325,"T6-47",0), array(7333,"T6-47",2), array(7326,"T6-48",0), array(7332,"T6-48",2), 
        array(7346,"T6-51",0), array(7340,"T6-51",2), array(7344,"T6-52",0), array(7353,"T6-52",2), 
        array(7338,"T6-53",0), array(7343,"T6-53",2), array(7352,"T6-54",0), array(7339,"T6-54",2), 
        array(7350,"T6-61",0), array(7345,"T6-61",2), array(7351,"T6-62",0), array(7347,"T6-62",2), 
        array(7341,"T6-63",0), array(7349,"T6-63",2), array(7342,"T6-64",0), array(7348,"T6-64",2), 
        array(7362,"T6-55",0), array(7356,"T6-55",2), array(7360,"T6-56",0), array(7369,"T6-56",2), 
        array(7354,"T6-57",0), array(7359,"T6-57",2), array(7368,"T6-58",0), array(7355,"T6-58",2), 
        array(7366,"T6-65",0), array(7361,"T6-65",2), array(7367,"T6-66",0), array(7363,"T6-66",2), 
        array(7357,"T6-67",0), array(7365,"T6-67",2), array(7358,"T6-68",0), array(7364,"T6-68",2), 
        array(7378,"T6-71",0), array(7372,"T6-71",2), array(7376,"T6-72",0), array(7385,"T6-72",2), 
        array(7370,"T6-73",0), array(7375,"T6-73",2), array(7384,"T6-74",0), array(7371,"T6-74",2), 
        array(7382,"T6-81",0), array(7377,"T6-81",2), array(7383,"T6-82",0), array(7379,"T6-82",2), 
        array(7373,"T6-83",0), array(7381,"T6-83",2), array(7374,"T6-84",0), array(7380,"T6-84",2), 
        array(7394,"T6-75",0), array(7388,"T6-75",2), array(7392,"T6-76",0), array(7401,"T6-76",2), 
        array(7386,"T6-77",0), array(7391,"T6-77",2), array(7400,"T6-78",0), array(7387,"T6-78",2), 
        array(7398,"T6-85",0), array(7393,"T6-85",2), array(7399,"T6-86",0), array(7395,"T6-86",2), 
        array(7389,"T6-87",0), array(7397,"T6-87",2), array(7390,"T6-88",0), array(7396,"T6-88",2), 
        array(7410,"T6-91",0), array(7404,"T6-91",2), array(7408,"T6-92",0), array(7417,"T6-92",2), 
        array(7402,"T6-93",0), array(7407,"T6-93",2), array(7416,"T6-94",0), array(7403,"T6-94",2), 
        array(7414,"T6-101",0), array(7409,"T6-101",2), array(7415,"T6-102",0), array(7411,"T6-102",2), 
        array(7405,"T6-103",0), array(7413,"T6-103",2), array(7406,"T6-104",0), array(7412,"T6-104",2), 
        array(7426,"T6-95",0), array(7420,"T6-95",2), array(7424,"T6-96",0), array(7433,"T6-96",2), 
        array(7418,"T6-97",0), array(7423,"T6-97",2), array(7432,"T6-98",0), array(7419,"T6-98",2), 
        array(7430,"T6-105",0), array(7425,"T6-105",2), array(7431,"T6-106",0), array(7427,"T6-106",2), 
        array(7421,"T6-107",0), array(7429,"T6-107",2), array(7422,"T6-108",0), array(7428,"T6-108",2), 
        array(7442,"T6-111",0), array(7436,"T6-111",2), array(7440,"T6-112",0), array(7449,"T6-112",2), 
        array(7434,"T6-113",0), array(7439,"T6-113",2), array(7448,"T6-114",0), array(7435,"T6-114",2), 
        array(7446,"T6-121",0), array(7441,"T6-121",2), array(7447,"T6-122",0), array(7443,"T6-122",2), 
        array(7437,"T6-123",0), array(7445,"T6-123",2), array(7438,"T6-124",0), array(7444,"T6-124",2), 
        array(7458,"T6-115",0), array(7452,"T6-115",2), array(7456,"T6-116",0), array(7465,"T6-116",2), 
        array(7450,"T6-117",0), array(7455,"T6-117",2), array(7464,"T6-118",0), array(7451,"T6-118",2), 
        array(7462,"T6-125",0), array(7457,"T6-125",2), array(7463,"T6-126",0), array(7459,"T6-126",2), 
        array(7453,"T6-127",0), array(7461,"T6-127",2), array(7454,"T6-128",0), array(7460,"T6-128",2), 
        array(7474,"T6-131",0), array(7468,"T6-131",2), array(7472,"T6-132",0), array(7481,"T6-132",2), 
        array(7466,"T6-133",0), array(7471,"T6-133",2), array(7480,"T6-134",0), array(7467,"T6-134",2), 
        array(7478,"T6-141",0), array(7473,"T6-141",2), array(7479,"T6-142",0), array(7475,"T6-142",2), 
        array(7469,"T6-143",0), array(7477,"T6-143",2), array(7470,"T6-144",0), array(7476,"T6-144",2), 
        array(7490,"T6-135",0), array(7484,"T6-135",2), array(7488,"T6-136",0), array(7497,"T6-136",2), 
        array(7482,"T6-137",0), array(7487,"T6-137",2), array(7496,"T6-138",0), array(7483,"T6-138",2), 
        array(7494,"T6-145",0), array(7489,"T6-145",2), array(7495,"T6-146",0), array(7491,"T6-146",2), 
        array(7485,"T6-147",0), array(7493,"T6-147",2), array(7486,"T6-148",0), array(7492,"T6-148",2), 
        array(7506,"T6-151",0), array(7500,"T6-151",2), array(7504,"T6-152",0), array(7513,"T6-152",2), 
        array(7498,"T6-153",0), array(7503,"T6-153",2), array(7512,"T6-154",0), array(7499,"T6-154",2), 
        array(7510,"T6-161",0), array(7505,"T6-161",2), array(7511,"T6-162",0), array(7507,"T6-162",2), 
        array(7501,"T6-163",0), array(7509,"T6-163",2), array(7502,"T6-164",0), array(7508,"T6-164",2), 
        array(7522,"T6-155",0), array(7516,"T6-155",2), array(7520,"T6-156",0), array(7529,"T6-156",2), 
        array(7514,"T6-157",0), array(7519,"T6-157",2), array(7528,"T6-158",0), array(7515,"T6-158",2), 
        array(7526,"T6-165",0), array(7521,"T6-165",2), array(7527,"T6-166",0), array(7523,"T6-166",2), 
        array(7517,"T6-167",0), array(7525,"T6-167",2), array(7518,"T6-168",0), array(7524,"T6-168",2), 
        array(7538,"T6-171",0), array(7532,"T6-171",2), array(7536,"T6-172",0), array(7545,"T6-172",2), 
        array(7530,"T6-173",0), array(7535,"T6-173",2), array(7544,"T6-174",0), array(7531,"T6-174",2), 
        array(7542,"T6-181",0), array(7537,"T6-181",2), array(7543,"T6-182",0), array(7539,"T6-182",2), 
        array(7533,"T6-183",0), array(7541,"T6-183",2), array(7534,"T6-184",0), array(7540,"T6-184",2), 
        array(7554,"T6-175",), array(7548,"T6-175",), array(7552,"T6-176",), array(7561,"T6-176",), 
        array(7546,"T6-177",), array(7551,"T6-177",), array(7560,"T6-178",), array(7547,"T6-178",), 
        array(7558,"T6-185",), array(7553,"T6-185",), array(7559,"T6-186",), array(7555,"T6-186",), 
        array(7549,"T6-187",), array(7557,"T6-187",), array(7550,"T6-188",), array(7556,"T6-188",)
    );
    //varudump($point_id);
    //meter_id => (select meter_id from Point where id = "ponit_id")
?>