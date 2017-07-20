--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: fridge; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE fridge (
    id bigint NOT NULL,
    cn text,
    key text,
    locale text,
    lat double precision,
    lon double precision,
    alt integer
);


ALTER TABLE public.fridge OWNER TO commandus_buynshare1;

--
-- Name: fridge_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE fridge_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.fridge_id_seq OWNER TO commandus_buynshare1;

--
-- Name: fridge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE fridge_id_seq OWNED BY fridge.id;


--
-- Name: fridgeuser; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE fridgeuser (
    id bigint NOT NULL,
    fridge_id bigint NOT NULL,
    user_id bigint NOT NULL,
    start integer,
    finish integer,
    balance double precision
);


ALTER TABLE public.fridgeuser OWNER TO commandus_buynshare1;

--
-- Name: fridgeuser_fridge_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE fridgeuser_fridge_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.fridgeuser_fridge_id_seq OWNER TO commandus_buynshare1;

--
-- Name: fridgeuser_fridge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE fridgeuser_fridge_id_seq OWNED BY fridgeuser.fridge_id;


--
-- Name: fridgeuser_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE fridgeuser_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.fridgeuser_id_seq OWNER TO commandus_buynshare1;

--
-- Name: fridgeuser_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE fridgeuser_id_seq OWNED BY fridgeuser.id;


--
-- Name: fridgeuser_user_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE fridgeuser_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.fridgeuser_user_id_seq OWNER TO commandus_buynshare1;

--
-- Name: fridgeuser_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE fridgeuser_user_id_seq OWNED BY fridgeuser.user_id;


--
-- Name: meal; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE meal (
    id bigint NOT NULL,
    cn text,
    locale text
);


ALTER TABLE public.meal OWNER TO commandus_buynshare1;

--
-- Name: meal_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE meal_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.meal_id_seq OWNER TO commandus_buynshare1;

--
-- Name: meal_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE meal_id_seq OWNED BY meal.id;


--
-- Name: mealcard; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE mealcard (
    id bigint NOT NULL,
    fridge_id bigint NOT NULL,
    user_id bigint NOT NULL,
    qty integer
);


ALTER TABLE public.mealcard OWNER TO commandus_buynshare1;

--
-- Name: mealcard_fridge_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE mealcard_fridge_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.mealcard_fridge_id_seq OWNER TO commandus_buynshare1;

--
-- Name: mealcard_fridge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE mealcard_fridge_id_seq OWNED BY mealcard.fridge_id;


--
-- Name: mealcard_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE mealcard_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.mealcard_id_seq OWNER TO commandus_buynshare1;

--
-- Name: mealcard_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE mealcard_id_seq OWNED BY mealcard.id;


--
-- Name: mealcard_user_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE mealcard_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.mealcard_user_id_seq OWNER TO commandus_buynshare1;

--
-- Name: mealcard_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE mealcard_user_id_seq OWNED BY mealcard.user_id;


--
-- Name: purchase; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE purchase (
    id bigint NOT NULL,
    fridge_id bigint NOT NULL,
    user_id bigint NOT NULL,
    meal_id bigint NOT NULL,
    cost double precision,
    start integer,
    finish integer
);


ALTER TABLE public.purchase OWNER TO commandus_buynshare1;

--
-- Name: purchase_fridge_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE purchase_fridge_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.purchase_fridge_id_seq OWNER TO commandus_buynshare1;

--
-- Name: purchase_fridge_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE purchase_fridge_id_seq OWNED BY purchase.fridge_id;


--
-- Name: purchase_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE purchase_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.purchase_id_seq OWNER TO commandus_buynshare1;

--
-- Name: purchase_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE purchase_id_seq OWNED BY purchase.id;


--
-- Name: purchase_meal_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE purchase_meal_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.purchase_meal_id_seq OWNER TO commandus_buynshare1;

--
-- Name: purchase_meal_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE purchase_meal_id_seq OWNED BY purchase.meal_id;


--
-- Name: purchase_user_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE purchase_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.purchase_user_id_seq OWNER TO commandus_buynshare1;

--
-- Name: purchase_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE purchase_user_id_seq OWNED BY purchase.user_id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE "user" (
    id bigint NOT NULL,
    cn text,
    key text,
    locale text,
    lat double precision,
    lon double precision,
    alt integer
);


ALTER TABLE public."user" OWNER TO commandus_buynshare1;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_id_seq OWNER TO commandus_buynshare1;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE user_id_seq OWNED BY "user".id;


--
-- Name: vote; Type: TABLE; Schema: public; Owner: commandu; Tablespace: 
--

CREATE TABLE vote (
    id bigint NOT NULL,
    purchase_id bigint NOT NULL,
    user_id bigint NOT NULL,
    val integer
);


ALTER TABLE public.vote OWNER TO commandus_buynshare1;

--
-- Name: vote_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE vote_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.vote_id_seq OWNER TO commandus_buynshare1;

--
-- Name: vote_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE vote_id_seq OWNED BY vote.id;


--
-- Name: vote_purchase_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE vote_purchase_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.vote_purchase_id_seq OWNER TO commandus_buynshare1;

--
-- Name: vote_purchase_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE vote_purchase_id_seq OWNED BY vote.purchase_id;


--
-- Name: vote_user_id_seq; Type: SEQUENCE; Schema: public; Owner: commandu
--

CREATE SEQUENCE vote_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.vote_user_id_seq OWNER TO commandus_buynshare1;

--
-- Name: vote_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: commandu
--

ALTER SEQUENCE vote_user_id_seq OWNED BY vote.user_id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY fridge ALTER COLUMN id SET DEFAULT nextval('fridge_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY fridgeuser ALTER COLUMN id SET DEFAULT nextval('fridgeuser_id_seq'::regclass);


--
-- Name: fridge_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY fridgeuser ALTER COLUMN fridge_id SET DEFAULT nextval('fridgeuser_fridge_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY fridgeuser ALTER COLUMN user_id SET DEFAULT nextval('fridgeuser_user_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY meal ALTER COLUMN id SET DEFAULT nextval('meal_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY mealcard ALTER COLUMN id SET DEFAULT nextval('mealcard_id_seq'::regclass);


--
-- Name: fridge_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY mealcard ALTER COLUMN fridge_id SET DEFAULT nextval('mealcard_fridge_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY mealcard ALTER COLUMN user_id SET DEFAULT nextval('mealcard_user_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase ALTER COLUMN id SET DEFAULT nextval('purchase_id_seq'::regclass);


--
-- Name: fridge_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase ALTER COLUMN fridge_id SET DEFAULT nextval('purchase_fridge_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase ALTER COLUMN user_id SET DEFAULT nextval('purchase_user_id_seq'::regclass);


--
-- Name: meal_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase ALTER COLUMN meal_id SET DEFAULT nextval('purchase_meal_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY "user" ALTER COLUMN id SET DEFAULT nextval('user_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY vote ALTER COLUMN id SET DEFAULT nextval('vote_id_seq'::regclass);


--
-- Name: purchase_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY vote ALTER COLUMN purchase_id SET DEFAULT nextval('vote_purchase_id_seq'::regclass);


--
-- Name: user_id; Type: DEFAULT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY vote ALTER COLUMN user_id SET DEFAULT nextval('vote_user_id_seq'::regclass);


--
-- Name: fridge_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY fridge
    ADD CONSTRAINT fridge_pkey PRIMARY KEY (id);


--
-- Name: fridgeuser_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY fridgeuser
    ADD CONSTRAINT fridgeuser_pkey PRIMARY KEY (id);


--
-- Name: meal_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY meal
    ADD CONSTRAINT meal_pkey PRIMARY KEY (id);


--
-- Name: mealcard_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY mealcard
    ADD CONSTRAINT mealcard_pkey PRIMARY KEY (id);


--
-- Name: purchase_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY purchase
    ADD CONSTRAINT purchase_pkey PRIMARY KEY (id);


--
-- Name: user_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY "user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: vote_pkey; Type: CONSTRAINT; Schema: public; Owner: commandu; Tablespace: 
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT vote_pkey PRIMARY KEY (id);


--
-- Name: fk_meal_fridge; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX fk_meal_fridge ON purchase USING btree (meal_id);


--
-- Name: fk_purchase_start; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX fk_purchase_start ON purchase USING btree (start);


--
-- Name: fk_purchase_user; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX fk_purchase_user ON purchase USING btree (user_id);


--
-- Name: idx_fridge_locale; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX idx_fridge_locale ON fridge USING btree (locale);


--
-- Name: idx_meal_cn; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX idx_meal_cn ON meal USING btree (cn);


--
-- Name: idx_meal_locale; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX idx_meal_locale ON meal USING btree (locale);


--
-- Name: idx_purchase_fridge; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX idx_purchase_fridge ON purchase USING btree (fridge_id);


--
-- Name: idx_user_locale; Type: INDEX; Schema: public; Owner: commandu; Tablespace: 
--

CREATE INDEX idx_user_locale ON "user" USING btree (locale);


--
-- Name: fk_fridgeuser_fridge; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY fridgeuser
    ADD CONSTRAINT fk_fridgeuser_fridge FOREIGN KEY (fridge_id) REFERENCES fridge(id);


--
-- Name: fk_fridgeuser_user; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY fridgeuser
    ADD CONSTRAINT fk_fridgeuser_user FOREIGN KEY (user_id) REFERENCES "user"(id);


--
-- Name: fk_mealcard_fridge; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY mealcard
    ADD CONSTRAINT fk_mealcard_fridge FOREIGN KEY (fridge_id) REFERENCES fridge(id);


--
-- Name: fk_purchase_fridge; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase
    ADD CONSTRAINT fk_purchase_fridge FOREIGN KEY (fridge_id) REFERENCES fridge(id);


--
-- Name: fk_purchase_meal; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase
    ADD CONSTRAINT fk_purchase_meal FOREIGN KEY (meal_id) REFERENCES meal(id);


--
-- Name: fk_purchase_user; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY purchase
    ADD CONSTRAINT fk_purchase_user FOREIGN KEY (user_id) REFERENCES "user"(id);


--
-- Name: fk_vote_purchase; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT fk_vote_purchase FOREIGN KEY (purchase_id) REFERENCES purchase(id);


--
-- Name: fk_vote_user; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY vote
    ADD CONSTRAINT fk_vote_user FOREIGN KEY (user_id) REFERENCES "user"(id);


--
-- Name: mealcard_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: commandu
--

ALTER TABLE ONLY mealcard
    ADD CONSTRAINT mealcard_user_id_fkey FOREIGN KEY (user_id) REFERENCES "user"(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--
