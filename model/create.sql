PRAGMA foreign_keys=ON;
CREATE TABLE IF NOT EXISTS USERS (
    id INTEGER PRIMARY KEY AUTOINCREMENT,

    username TEXT(64) NOT NULL UNIQUE,
    pwd TEXT,
    reg_date INTEGER,

    session_cookie TEXT(16),
    cookie_date INTEGER
);

CREATE TABLE IF NOT EXISTS VIDEOS(
    id INTEGER PRIMARY KEY AUTOINCREMENT,

    title TEXT(64) NOT NULL,
    description TEXT(4096),
    pub_date INTEGER,
    creator_id INTEGER,
    views INTEGER,
    
    FOREIGN KEY (creator_id) REFERENCES USERS(id)
);

CREATE TABLE IF NOT EXISTS COMMENTS(
    id INTEGER PRIMARY KEY AUTOINCREMENT,

    content TEXT(8192) NOT NULL,
    pub_date INTEGER,

    poster_id INTEGER,
    vid_id INTEGER,
    FOREIGN KEY(poster_id) REFERENCES USERS(id),
    FOREIGN KEY(vid_id) REFERENCES VIDEOS(id)
);

CREATE TABLE IF NOT EXISTS SUBSCRIBTIONS(
    channel_id INTEGER,
    subscriber_id INTEGER,
    last_seen INTEGER,

    FOREIGN KEY(channel_id) REFERENCES USERS(id),
    FOREIGN KEY(subscriber_id) REFERENCES USERS(id),

    PRIMARY KEY(channel_id, subscriber_id)
);

CREATE TABLE IF NOT EXISTS TAGS(
    tag TEXT(32) PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS VIDEO_TAGS(
    vid_id INTEGER,
    tag TEXT(32),

    FOREIGN KEY(vid_id) REFERENCES VIDEOS(id),
    FOREIGN KEY(tag) REFERENCES TAGS(tag),

    PRIMARY KEY(vid_id, tag)
);
