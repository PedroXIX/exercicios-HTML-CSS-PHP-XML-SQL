create database banco;
use banco;
-- Estrutura da tabela 
create table if not exists tabelol(
id int not null AUTO_INCREMENT,
nome varchar(80) not null,
funcao varchar(15) not null,
dificuldade varchar(50) not null,
descricao varchar(800) not null,
habilidadeEs varchar(150) not null,
imagem varchar(100) not null,
primary key (id)) default charset=utf8;

insert into tabelol(id,nome,funcao,dificuldade,descricao,habilidadeEs,imagem)
values
(NULL, 'Ahri', 'mago', 'moderado', 'Com uma conexão inata com o poder latente de Runeterra,
 Ahri é uma vastaya capaz de transformar magia em orbes de pura energia. Ela gosta de brincar
 com suas presas manipulando suas emoções antes de devorar suas essências vitais. Apesar de sua natureza predatória, 
 Ahri conserva um senso de empatia ao receber flashes de memória das almas que ela consome.','ÍMPETO ESPIRITUAL', 'ahri.jpg'),
(NULL, 'Heimerdinger', 'mago', 'alta', 'Um cientista brilhante, mesmo que excêntrico, o Professor Cecil B. Heimerdinger é um dos inventores mais inovadores
 e estimados que Piltover já conheceu. Incansável em seu trabalho ao ponto da obsessão neurótica, ele busca responder as questões mais impenetráveis do universo.
 Apesar de suas teorias frequentemente parecerem obscuras e esotéricas, Heimerdinger produziu algumas das máquinas mais miraculosas, sem mencionar letais, de Piltover 
 e ajusta constantemente suas invenções para torná-las ainda mais eficientes.', 'MELHORIA!!!', 'heimerdinger.jpg'),
 (NULL, 'Dr. Mundo', 'lutador', 'moderado', 'Completamente maluco, tragicamente perigoso e terrivelmente roxo, Dr. Mundo é
 o que mantém muitos zaunitas dentro de casa nas noites mais escuras. Hoje se diz médico, mas ele já foi um paciente do manicômio 
 mais infame de Zaun. Após ''curar'' toda a equipe do local, Dr. Mundo começou a atuar em sua nova profissão nos corredores vazios do 
 lugar em que um dia fora tratado, repetindo os procedimentos extremamente antiéticos pelos quais ele mesmo havia passado. Munido de um 
 armário cheio de remédios e nenhum conhecimento médico, ele fica mais monstruoso a cada nova injeção e continua instilando medo nos infelizes 
 ''pacientes'' que passam perto de sua ''clínica''.','DOSAGEM MÁXIMA', 'drmundo.jpg'),
(NULL, 'Darius', 'lutador', 'baixa', 'Não há símbolo maior do poder de Noxus do que Darius, o mais temido e experiente comandante da nação. Vindo de origens humildes para se tornar a Mão de 
Noxus, ele corta seu caminho através dos inimigos do império; muitos dos quais são, inclusive, noxianos. Sabendo que ele nunca duvida da integridade de sua causa e que nunca hesita assim que
 seu machado é levantado, aqueles que desafiam o comandante da Legião Trifária não esperam por misericórdia.', 'GUILHOTINA DE NOXUS', 'darius.jpg'),
(NULL, 'Akali', 'assassino', 'moderado', 'Abandonando a Ordem Kinkou e seu título de Punho das Sombras, Akali agora ataca sozinha, pronta para 
ser a arma mortal que seu povo precisa. Embora ela mantenha tudo o que aprendeu com seu mestre Shen, ela se comprometeu a defender Ionia de seus
 inimigos, um assassinato de cada vez. Akali pode atacar em silêncio, mas sua mensagem será ouvida em voz alta e clara: “Temam a assassina sem mestre”.', 'EXECUÇÃO PERFEITA', 'akali.jpg'),
 (NULL, 'Nocturne', 'assassino', 'moderado', 'Uma fusão demoníaca provinda dos pesadelos que assombram todas as mentes 
 sencientes, a coisa conhecida como Nocturne se tornou uma força primordial de puro terror. De aspecto caótico e líquido, ele 
 é uma sombra sem rosto com olhos frios e armada com lâminas enfurecidas. Depois de se libertar do mundo dos espíritos, Nocturne desceu
 para o mundo dos vivos para se alimentar de um terror que só pode ser cultivado na verdadeira escuridão.', 'PARANOIA', 'nocturne.jpg');
 
select * from tabelol ;
drop table tabelol;
