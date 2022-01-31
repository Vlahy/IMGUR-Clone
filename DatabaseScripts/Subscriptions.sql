USE `quant-zadatak`;

create table user_payment
(
    id           int auto_increment primary key,
    user_id      int          not null,
    payment_type varchar(255) null,
    is_valid     bool         not null,
    CONSTRAINT fk_payment_user_id FOREIGN KEY (user_id)
        REFERENCES user (id)
        ON DELETE CASCADE
)
    COLLATE utf8mb4_unicode_ci;

create table user_subscriptions
(
    id                int auto_increment primary key,
    user_id           int      not null,
    subscription_type enum ('free', 'one_month', 'six_months', 'twelve_months') default 'free' not null,
    start_date        datetime not null,
    end_date          datetime not null,
    is_active         bool     not null,
    monthly_limit     int      null                                             default 5,
    uploaded_images   int      null,
    CONSTRAINT fk_subscriptions_user_id FOREIGN KEY (user_id)
        REFERENCES user (id)
        ON DELETE CASCADE
)
    COLLATE utf8mb4_unicode_ci;
