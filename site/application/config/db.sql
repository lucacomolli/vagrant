drop schema if exists gestionaleband;
create schema if not exists gestionaleband;
use gestionaleband;
create table user(
    id int primary key auto_increment,
    name varchar(100) not null,
    surname varchar(100) not null,
    email varchar(100) not null,
    authLevel tinyint(1) default 0,
    password char(64) not null
);
create table band(
    id int primary key auto_increment,
    name varchar(100) not null
);
create table band_user(
    bandId int,
    userId int,
    isAdmin tinyint(1),
    foreign key(userId) references user(id) ON DELETE CASCADE,
    foreign key(bandId) references band(id) ON DELETE CASCADE
);
create table song (
    id int primary key auto_increment,
    title varchar(500) not null,
    author varchar(500) not null,
    year int not null,
    description longtext not null,
    audio varchar(500),
    video varchar(500),
    cover varchar(500),
    album varchar(500) not null,
    text longtext not null,
    bpm int default 100,
    genre varchar(500) not null,
    type varchar(500) not null,
    instruments text not null,
    notes longtext,
    bandId int,
    foreign key(bandId) references band(id) ON DELETE CASCADE
);
INSERT INTO band (id, name)
VALUES (1, 'The Beatles'),
    (2, 'Queen'),
    (3, 'NASKA');
INSERT INTO user (id, name, surname, email, password, authLevel)
VALUES (
        1,
        'Lucaste',
        'Cemolli',
        'admin@band.ch',
        sha2('Password&1', 256),
        1
    ),
    (
        2,
        'John',
        'Doe',
        'john.doe@band.ch',
        sha2('Password&1', 256),
        0
    ),
    (
        3,
        'Jane',
        'Smith',
        'jane.smith@band.ch',
        sha2('Password&1', 256),
        0
    );
INSERT INTO band_user (bandId, userId)
VALUES (1, 1),
    (2, 1),
    (3, 1),
    (2, 2),
    (2, 3);
INSERT INTO `song`
VALUES (
        1,
        'Hey Jude',
        'The Beatles',
        1968,
        'A classic rock anthem by The Beatles',
        'uploads/audios/sample_heyjude.mp3',
        'uploads/videos/sample_heyjude.mp4',
        'uploads/artworks/sample_heyjude.png',
        'The Beatles (White Album)',
        'Hey Jude, don\'t make it bad.\nTake a sad song and make it better.\nRemember to let her into your heart,\nThen you can start to make it better.\nHey Jude, don\'t be afraid.\nYou were made to go out and get her.\nThe minute you let her under your skin,\nThen you begin to make it better.\nAnd anytime you feel the pain, hey Jude, refrain,\nDon\'t carry the world upon your shoulders.\nFor well you know that it\'s a fool who plays it cool\nBy making his world a little colder.\nHey Jude, don\'t let me down.\nYou have found her, now go and get her.\nRemember to let her into your heart,\nThen you can start to make it better.\nSo let it out and let it in, hey Jude, begin,\nYou\'re waiting for someone to perform with.\nAnd don\'t you know that it\'s just you, hey Jude, you\'ll do,\nThe movement you need is on your shoulder.\nHey Jude, don\'t make it bad.\nTake a sad song and make it better.\nRemember to let her under your skin,\nThen you\'ll begin to make it\nBetter better better better better better, oh.\nNa na na nananana, nannana, hey Jude... ',
        120,
        'Rock',
        'Single',
        'Guitar, Bass, Drums',
        NULL,
        1
    ),
    (
        2,
        'Bohemian Rhapsody',
        'Queen',
        1975,
        'A six-minute rock opera by Queen',
        'uploads/audios/sample_queen.mp3',
        'uploads/videos/sample_queen.mp4',
        'uploads/artworks/sample_queen.png',
        'A Night at the Opera',
        'Is this the real life? Is this just fantasy?\nCaught in a landslide, no escape from reality\nOpen your eyes, look up to the skies and see\nI\'m just a poor boy, I need no sympathy\nBecause I\'m easy come, easy go, little high, little low\nAny way the wind blows doesn\'t really matter to me, to me\nMama, just killed a man\nPut a gun against his head, pulled my trigger, now he\'s dead\nMama, life had just begun\nBut now I\'ve gone and thrown it all away\nMama, ooh, didn\'t mean to make you cry\nIf I\'m not back again this time tomorrow\nCarry on, carry on as if nothing really matters\nToo late, my time has come\nSends shivers down my spine, body\'s aching all the time\nGoodbye, everybody, I\'ve got to go\nGotta leave you all behind and face the truth\nMama, ooh (any way the wind blows)\nI don\'t wanna die\nI sometimes wish I\'d never been born at all\nI see a little silhouetto of a man\nScaramouche, Scaramouche, will you do the Fandango?\nThunderbolt and lightning, very, very frightening me\n(Galileo) Galileo, (Galileo) Galileo, Galileo Figaro, magnifico\nBut I\'m just a poor boy, nobody loves me\nHe\'s just a poor boy from a poor family\nSpare him his life from this monstrosity\nEasy come, easy go, will you let me go?\nبِسْمِ ٱللَّٰهِ\nNo, we will not let you go (let him go)\nبِسْمِ ٱللَّٰهِ\nWe will not let you go (let him go)\nبِسْمِ ٱللَّٰهِ\nWe will not let you go (let me go)\nWill not let you go (let me go)\nNever, never, never, never let me go\nNo, no, no, no, no, no, no\nOh, mamma mia, mamma mia\nMamma mia, let me go\nBeelzebub has a devil put aside for me, for me, for me\nSo you think you can stone me and spit in my eye?\nSo you think you can love me and leave me to die?\nOh, baby, can\'t do this to me, baby\nJust gotta get out, just gotta get right outta here\nOoh\nOoh, yeah, ooh, yeah\nNothing really matters, anyone can see\nNothing really matters\nNothing really matters to me',
        130,
        'Rock',
        'Single',
        'Piano, Guitar, Bass, Drums',
        NULL,
        2
    ),
    (
        3,
        'Fine Settembre',
        'NASKA',
        2023,
        'This song captures the nostalgia and longing associated with the end of a summer love, leaving behind memories of a short-lived but intense relationship.',
        'uploads/audios/sample_fineSettembre.mp3',
        'uploads/videos/sample_fineSettembre.mp4',
        'uploads/artworks/sample_lamiastanzadeluxe.png',
        'La Mia Stanza (Deluxe)',
        'Finisce l\'ultima festa, a calci in culo fuori dal locale\nNon ti vedo più in mezzo a ste facce strane\nTi volevo chiedere se dormiamo in spiaggia, che non posso guidare\nE ora cosa ci resta?\nSabbia nelle scarpe\nTimbri sulle mani che non vogliono andarsene\nNumeri di sconosciute sul cellulare\nFoto che cancellerò sicuro tra qualche estate\nA testa bassa con le cuffiette\nIn metropolitana chi è triste e chi mente\nNoi ci ricordiamo di scendere ma\nDimentichiamo le promesse\nE già finito settembre\nChe cosa ti aspettavi? Mon è cambiato niente\nCi sono i segni delle sigarette\nSpente sulla pelle, sembra lunedì per sempre\nMa lasciami dormire ancora un po\' qui\nE non svegliarmi più\nQuale lato vuoi del letto?\nDai senti che calda\nTe lo chiedo anche se poi dormiamo l\'uno sull\'altra\nQuesta camera dall\'albergo senza le pareti\nMentre al mondo cade a pezzi, noi compresi\nE vorrei rivederti quest\'inverno\nCon la tua sciarpa e il naso freddo\nNon come adesso, due sconosciuti\nDa un giorno all\'altro senza senso\nA testa bassa con le cuffiette\nIn metropolitana chi è triste e chi mente\nNoi, ci dicevamo per sempre ma non ci credevamo veramente\nE già finito settembre\nChe cosa ti aspettavi? Non è cambiato niente\nCi sono i segni delle sigarette\nSpente sulla pelle, sembra lunedì per sempre\nMa lasciami dormire ancora un po\' qui\nE non svegliarmi più\nE non svegliarmi più\nNon svegliarmi più\nE l\'hit estiva anche di quest\'estate a me ha fatto cagare\nNon parla di noi\nNon voglio più andare in disco a ballare\nRestiamo a fumare qua sugli scogli\nPoi quando il treno ripartirà\nNoi rimpiangeremo questi momenti\nMi è lasciato in testa dei bei ricordi\nE sul collo pure il segno dei denti\nE già finito settembre\nChe cosa ti aspettavi? Non è cambiato niente\nCi sono i segni delle sigarette\nSpente sulla pelle, sembra lunedì per sempre\nMa lasciami dormire ancora un po\' qui\n(Lasciami dormire ancora un po\' qui)\nE non svegliarmi più\nE non svegliarmi più\nNon svegliarmi più',
        166,
        'Punk, Rock, Pop',
        'Single',
        'Guitar, Bass, Drums',
        '[LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END][LN_END]',
        3
    );