CREATE TABLE lorawan_modelos (
    modelo varchar(50) NOT NULL,
    fabricante varchar(50) NOT NULL,    
    quantidade_medidores int(5) NOT NULL,
    PRIMARY KEY (modelo)
);

CREATE TABLE lorawan_devices (
    device_addr varchar(15) NOT NULL,
    modelo varchar(50),
    planta int (11) NOT NULL,
    PRIMARY KEY (device_addr),
    FOREIGN KEY (planta) REFERENCES planta(idecoflow),
    FOREIGN KEY (modelo) REFERENCES lorawan_modelos(modelo)

);

CREATE TABLE lorawan_unidades (
    nome varchar(20) NOT NULL,
    medidor int(10) NOT NULL,
    servico tinyint(1) NOT NULL,
    device_addr varchar(15),
    PRIMARY KEY (nome),
    FOREIGN KEY (device_addr) REFERENCES lorawan_devices(device_addr)
);

CREATE TABLE lorawan_idecoflow (
    idecoflow varchar(15) NOT NULL,
    nome varchar(20),
    PRIMARY KEY (idecoflow),
    FOREIGN KEY (nome) REFERENCES lorawan_unidades(nome)
);

CREATE TABLE lorawan_status (
    device_addr varchar(15),
    tempo date NOT NULL,
    hora time NOT NULL,
    snr int(15) NOT NULL,
    rssi int(15) NOT NULL,
    nivel_bateria float NOT NULL,
    PRIMARY KEY (device_addr, tempo, hora),
    FOREIGN KEY (device_addr) REFERENCES lorawan_devices(device_addr)    
);