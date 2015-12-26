

TRUNCATE TABLE volvoapp3.contato;

-- importa os dados da transicao para a base quente.
INSERT INTO volvoapp3.contato
(
 contato_grupo, contato_nome_empresa, contato_nro_cdb,
 contato_cargo, contato_cod_identif, contato_dat_nasc, contato_inativo, contato_nome_meio,
 contato_nome, contato_sobrenome, contato_telefone, contato_celular, contato_email, telefone,
 contato_cod_interesse
)
SELECT
 c.grupo, c.nome, c.`numero_do_cliente_CDB`, c.`contato_cargo`, c.`contato_codigo_de_identificacao`,
 c.`contato_data_de_nascimento`, c.contato_inativo, c.`contato_nome_do_meio`,
 c.contato_nome, c.contato_sobrenome, c.`contato_telefone`, c.contato_celular, c.contato_email,
 c.`telefone`, c.codigo_de_interesse
FROM transicao.`contatos` c;


TRUNCATE TABLE volvoapp3.cliente;

-- importa os dados da transicao (clientes) para a base quente (cliente)
INSERT INTO volvoapp3.cliente
(
grupo, nome, numero_cdb, cpf_cnpj, telefone, email, codigo_grupo_cliente, aplicacao_1, industria_servida_1, oficina,
participacao_negocio, tamanho_frota, tamanho_frota_volvo, tipo_conta, endereco, complemento1, complemento2, cep,
cidade, municipio, estado, pais
)
SELECT
grupo, nome, numero_do_cliente_cdb, cpf_cnpj, telefone, email, codigo_de_grupo_do_cliente,
`aplicacao_1`, `industria_servida_1`, oficina, `participacao_no_negocio`, tamanho_da_frota, tamanho_da_frota_volvo,
tipo_de_conta, `endereco`, complemento1, complemento2, cep, cidade, municipio, estado, pais
FROM transicao.`clientes`;

