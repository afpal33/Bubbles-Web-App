-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2023-11-21 00:31:48.137

-- tables
-- Table: Promo
CREATE TABLE Promo (
    Id_Promo INT NOT NULL AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    costo_puntos INT NOT NULL,
    imagen MEDIUMBLOB, -- Cambio aquí para agregar la columna de imagen
    CONSTRAINT Promo_pk PRIMARY KEY (Id_Promo)
);


-- Table: Registro_compras_uso_servicios
CREATE TABLE Registro_compras_uso_servicios (
    COD int  NOT NULL AUTO_INCREMENT,
    Producto_servicio char(30)  NOT NULL,
    Valor char(30)  NOT NULL,
    Precio Decimal(10, 5)  NOT NULL,
    Información_sucursal_COD int  NOT NULL,
    Usuario_cliente_ID_usuario int  NOT NULL,
    Promo_Id_Promo int  NOT NULL,
    CONSTRAINT Registro_compras_uso_servicios_pk PRIMARY KEY (COD)
);

-- Table: Usuario_administrativo
CREATE TABLE Usuario_administrativo (
    ID_UA int  NOT NULL AUTO_INCREMENT,
    Nombre char(30)  NOT NULL,
    Contraseña  char(30)  NOT NULL,
    CI int  NOT NULL,
    CONSTRAINT Usuario_administrativo_pk PRIMARY KEY (ID_UA)
);

-- Table: queja_sugerencia
CREATE TABLE queja_sugerencia (
    COD_QS int  NOT NULL AUTO_INCREMENT,
    Usuario_cliente_ID_usuario int  NOT NULL,
    Descripción  int  NOT NULL,
    CONSTRAINT queja_sugerencia_pk PRIMARY KEY (COD_QS)
);

-- Table: sucursal
CREATE TABLE sucursal (
    COD int  NOT NULL AUTO_INCREMENT,
    Ubicación  char(30)  NOT NULL,
    Usuario_administrativo_ID_UA int  NOT NULL,
    Quejas_sugerencias_COD_QS int  NOT NULL,
    CONSTRAINT sucursal_pk PRIMARY KEY (COD)
);

-- Table: usuario_cliente
CREATE TABLE usuario_cliente (
    ID_usuario int  NOT NULL AUTO_INCREMENT,
    Nombre char(30)  NOT NULL,
    Contraseña char(30)  NOT NULL,
    Puntos_compra_acumulados int  NOT NULL,
    Correo Varchar(50)  NOT NULL,
    Telefono int  NOT NULL,
    Direccion Varchar(250)  NOT NULL,
    CONSTRAINT usuario_cliente_pk PRIMARY KEY (ID_usuario)
);

-- Table: servicio_usuario
CREATE TABLE servicio_usuario (
    id_serv int  NOT NULL AUTO_INCREMENT,
    Descripcion char(30)  NOT NULL,
    Fecha date  NOT NULL,
    Costo int NOT NULL,
    Puntos_obtenidos int  NOT NULL,
    Sucursal Varchar(50)  NOT NULL,
    id_usuario int NOT NULL,
    CONSTRAINT servicio_usuario_pk PRIMARY KEY (id_serv)
);


-- End of file.

