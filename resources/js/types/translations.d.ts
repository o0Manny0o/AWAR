type Translations = {
    auth: {
        failed: string
        password: string
        throttle: string
    }
    pagination: {
        previous: string
        next: string
    }
    passwords: {
        reset: string
        sent: string
        throttled: string
        token: string
        user: string
    }
    validation: {
        postal_code_with: string
        accepted: string
        accepted_if: string
        active_url: string
        after: string
        after_or_equal: string
        alpha: string
        alpha_dash: string
        alpha_num: string
        array: string
        ascii: string
        before: string
        before_or_equal: string
        between: {
            array: string
            file: string
            numeric: string
            string: string
        }
        boolean: string
        can: string
        confirmed: string
        contains: string
        current_password: string
        date: string
        date_equals: string
        date_format: string
        decimal: string
        declined: string
        declined_if: string
        different: string
        digits: string
        digits_between: string
        dimensions: string
        distinct: string
        doesnt_end_with: string
        doesnt_start_with: string
        email: string
        ends_with: string
        enum: string
        exists: string
        extensions: string
        file: string
        filled: string
        gt: {
            array: string
            file: string
            numeric: string
            string: string
        }
        gte: {
            array: string
            file: string
            numeric: string
            string: string
        }
        hex_color: string
        image: string
        in: string
        in_array: string
        integer: string
        ip: string
        ipv4: string
        ipv6: string
        json: string
        list: string
        lowercase: string
        lt: {
            array: string
            file: string
            numeric: string
            string: string
        }
        lte: {
            array: string
            file: string
            numeric: string
            string: string
        }
        mac_address: string
        max: {
            array: string
            file: string
            numeric: string
            string: string
        }
        max_digits: string
        mimes: string
        mimetypes: string
        min: {
            array: string
            file: string
            numeric: string
            string: string
        }
        min_digits: string
        missing: string
        missing_if: string
        missing_unless: string
        missing_with: string
        missing_with_all: string
        multiple_of: string
        not_in: string
        not_regex: string
        numeric: string
        password: {
            letters: string
            mixed: string
            numbers: string
            symbols: string
            uncompromised: string
        }
        present: string
        present_if: string
        present_unless: string
        present_with: string
        present_with_all: string
        prohibited: string
        prohibited_if: string
        prohibited_unless: string
        prohibits: string
        regex: string
        required: string
        required_array_keys: string
        required_if: string
        required_if_accepted: string
        required_if_declined: string
        required_unless: string
        required_with: string
        required_with_all: string
        required_without: string
        required_without_all: string
        same: string
        size: {
            array: string
            file: string
            numeric: string
            string: string
        }
        starts_with: string
        string: string
        timezone: string
        unique: string
        uploaded: string
        uppercase: string
        url: string
        ulid: string
        uuid: string
    }
    general: {
        languages: {
            en: string
            de: string
        }
        navigation: {
            register: string
            dashboard: string
            login: string
            logout: string
            profile: string
            about: string
            home: string
            organisations: {
                applications: string
                invitations: string
                members: string
                locations: string
                settings: string
            }
            overview: string
            your_organisations: string
            your_dashboard: string
            animals: {
                dogs: string
                cats: string
            }
            browse: string
            pricing: string
            self_disclosure: {
                finish: string
            }
        }
        newsletter: {
            description: string
            heading: string
            subscribe: string
        }
        legal: {
            rights_reserved: string
        }
        layout: {
            open_user_menu: string
            open_sidebar: string
            close_sidebar: string
        }
        status: {
            submitted: string
            pending: string
            approved: string
            rejected: string
            created: string
            draft: string
            sent: string
            accepted: string
            published: string
            unlisted: string
            public: string
            internal: string
        }
        button: {
            view: string
            edit: string
            delete: string
            open: string
            restore: string
            new: string
            submit: string
            continue: string
            save: string
            cancel: string
            go_back: string
            go_back_to: string
            send: string
            resend: string
            publish: string
            add: string
            update: string
            create: string
        }
        last_update: string
        options: string
        deleted: string
        your_resource: string
        continue_later: string
        resources: {
            organisation: {
                invitation: string
                application: string
                location: string
            }
            animals: {
                dog: string
                cat: string
                cats: {
                    listing: string
                }
                listing: string
            }
            family_member: string
            experience: string
        }
        roles: {
            tenant: {
                admin: string
                member: string
                foster_home_lead: string
                foster_home_handler: string
                foster_home: string
                animal_handler: string
                animal_lead: string
            }
        }
        images: string
        various: {
            no_one: string
            assigned_to: string
            unknown: string
            unknown_or_external: string
            for: string
            since: string
            years: string
        }
    }
    landing_page: {
        welcome_message: string
    }
    organisations: {
        applications: {
            form: {
                name: {
                    label: string
                    placeholder: string
                }
                type: {
                    label: string
                    placeholder: string
                }
                registered: {
                    label: string
                }
                street: {
                    label: string
                    placeholder: string
                }
                post_code: {
                    label: string
                    placeholder: string
                }
                city: {
                    label: string
                    placeholder: string
                }
                country: {
                    label: string
                    placeholder: string
                }
                general_info: string
                subdomain: {
                    placeholder: string
                    label: string
                }
                address_info: string
                subdomain_info: string
                cancel_create: string
                user_role: {
                    label: string
                    placeholder: string
                }
            }
        }
        invitations: {
            mail: {
                header: string
                body: string
                get_started: string
                regards: string
                subject: string
            }
            form: {
                email: {
                    label: string
                    placeholder: string
                }
                role: {
                    label: string
                    placeholder: string
                }
                token: {
                    label: string
                }
                cancel_create: string
            }
            titles: {
                create: string
                index: string
            }
            headers: {
                index: string
                create: string
            }
            messages: {
                sent: string
                expired: string
                accepted: string
                already_accepted: string
                wrong_email: string
            }
        }
        members: {
            headers: {
                index: string
            }
            titles: {
                index: string
            }
        }
        dashboard: {
            welcome: string
        }
        locations: {
            headers: {
                index: string
                create: string
                update: string
            }
            titles: {
                index: string
                create: string
                update: string
            }
            form: {
                cancel_create: string
                name: {
                    placeholder: string
                    label: string
                }
                public: {
                    description: string
                    label: string
                }
            }
        }
        settings: {
            public: {
                headers: {
                    update: string
                }
                titles: {
                    update: string
                }
                form: {
                    name: {
                        label: string
                    }
                }
            }
            logo: {
                headers: {
                    update: string
                }
                titles: {
                    update: string
                }
            }
            favicon: {
                headers: {
                    update: string
                }
                titles: {
                    update: string
                }
            }
        }
    }
    animals: {
        dogs: {
            headers: {
                index: string
                create: string
            }
            titles: {
                index: string
                create: string
                edit: string
            }
            form: {
                name: {
                    placeholder: string
                    label: string
                }
                breed: {
                    label: string
                    placeholder: string
                }
                date_of_birth: {
                    label: string
                    placeholder: string
                }
                bio: {
                    placeholder: string
                    label: string
                }
                abstract: {
                    placeholder: string
                    label: string
                }
                family: {
                    header: string
                }
            }
        }
        cats: {
            titles: {
                index: string
                create: string
                edit: string
                listings: string
            }
            headers: {
                index: string
                create: string
                listings: string
            }
            form: {
                name: {
                    label: string
                    placeholder: string
                }
                breed: {
                    placeholder: string
                    label: string
                }
                date_of_birth: {
                    placeholder: string
                    label: string
                }
                bio: {
                    placeholder: string
                    label: string
                }
                abstract: {
                    placeholder: string
                    label: string
                }
                family: {
                    header: string
                }
            }
        }
        form_general: {
            family: {
                placeholder: string
                label: string
            }
            location: {
                label: string
            }
            foster_home: {
                label: string
            }
        }
        general: {
            navigation: {
                animals: string
                listings: string
            }
        }
        listings: {
            headers: {
                create: string
                edit: string
            }
            cats: string
            dogs: string
            titles: {
                create: string
                edit: string
            }
            form: {
                description: {
                    label: string
                    placeholder: string
                }
                excerpt: {
                    label: string
                    placeholder: string
                    use_description: string
                }
                animals: {
                    label: string
                }
                images: {
                    label: string
                }
            }
        }
    }
    history: {
        changes: {
            internal: {
                initial: string
                update: string
                delete: string
                restore: string
                publish: string
                unpublish: string
                handler_assign: string
                location_assign: string
                foster_home_assign: string
                handler_unassign: string
                location_unassign: string
                foster_home_unassign: string
                listing_created: string
                listing_deleted: string
            }
            public: {
                initial: string
            }
        }
        title: string
    }
    countries: {
        af: string
        ax: string
        al: string
        dz: string
        as: string
        ad: string
        ao: string
        ai: string
        aq: string
        ag: string
        ar: string
        am: string
        aw: string
        au: string
        at: string
        az: string
        bs: string
        bh: string
        bd: string
        bb: string
        by: string
        be: string
        bz: string
        bj: string
        bm: string
        bt: string
        bo: string
        bq: string
        ba: string
        bw: string
        bv: string
        br: string
        io: string
        bn: string
        bg: string
        bf: string
        bi: string
        cv: string
        kh: string
        cm: string
        ca: string
        ky: string
        cf: string
        td: string
        cl: string
        cn: string
        cx: string
        cc: string
        co: string
        km: string
        cg: string
        cd: string
        ck: string
        cr: string
        ci: string
        hr: string
        cu: string
        cw: string
        cy: string
        cz: string
        dk: string
        dj: string
        dm: string
        do: string
        ec: string
        eg: string
        sv: string
        gq: string
        er: string
        ee: string
        sz: string
        et: string
        fk: string
        fo: string
        fj: string
        fi: string
        fr: string
        gf: string
        pf: string
        tf: string
        ga: string
        gm: string
        ge: string
        de: string
        gh: string
        gi: string
        gr: string
        gl: string
        gd: string
        gp: string
        gu: string
        gt: string
        gg: string
        gn: string
        gw: string
        gy: string
        ht: string
        hm: string
        va: string
        hn: string
        hk: string
        hu: string
        is: string
        in: string
        id: string
        ir: string
        iq: string
        ie: string
        im: string
        il: string
        it: string
        jm: string
        jp: string
        je: string
        jo: string
        kz: string
        ke: string
        ki: string
        kp: string
        kr: string
        kw: string
        kg: string
        la: string
        lv: string
        lb: string
        ls: string
        lr: string
        ly: string
        li: string
        lt: string
        lu: string
        mo: string
        mg: string
        mw: string
        my: string
        mv: string
        ml: string
        mt: string
        mh: string
        mq: string
        mr: string
        mu: string
        yt: string
        mx: string
        fm: string
        md: string
        mc: string
        mn: string
        me: string
        ms: string
        ma: string
        mz: string
        mm: string
        na: string
        nr: string
        np: string
        nl: string
        nc: string
        nz: string
        ni: string
        ne: string
        ng: string
        nu: string
        nf: string
        mk: string
        mp: string
        no: string
        om: string
        pk: string
        pw: string
        ps: string
        pa: string
        pg: string
        py: string
        pe: string
        ph: string
        pn: string
        pl: string
        pt: string
        pr: string
        qa: string
        re: string
        ro: string
        ru: string
        rw: string
        bl: string
        sh: string
        kn: string
        lc: string
        mf: string
        pm: string
        vc: string
        ws: string
        sm: string
        st: string
        sa: string
        sn: string
        rs: string
        sc: string
        sl: string
        sg: string
        sx: string
        sk: string
        si: string
        sb: string
        so: string
        za: string
        gs: string
        ss: string
        es: string
        lk: string
        sd: string
        sr: string
        sj: string
        se: string
        ch: string
        sy: string
        tw: string
        tj: string
        tz: string
        th: string
        tl: string
        tg: string
        tk: string
        to: string
        tt: string
        tn: string
        tr: string
        tm: string
        tc: string
        tv: string
        ug: string
        ua: string
        ae: string
        gb: string
        us: string
        um: string
        uy: string
        uz: string
        vu: string
        ve: string
        vn: string
        vg: string
        vi: string
        wf: string
        eh: string
        ye: string
        zm: string
        zw: string
    }
    addresses: {
        form: {
            street_address: {
                placeholder: string
                label: string
            }
            postal_code: {
                placeholder: string
                label: string
            }
            locality: {
                placeholder: string
                label: string
            }
            region: {
                placeholder: string
                label: string
            }
            country: {
                label: string
            }
        }
    }
    self_disclosure: {
        wizard: {
            steps: {
                personal: string
                family: string
                address: string
                home: string
                experiences: string
                garden: string
                eligibility: string
                specific: string
                confirmation: string
            }
            headers: {
                personal: string
                family: string
                address: string
                home: string
                experiences: string
                garden: string
                eligibility: string
                specific: string
                family_member: {
                    create: string
                    edit: string
                }
                experience: {
                    create: string
                    edit: string
                }
                confirmation: string
                complete: string
            }
            forms: {
                family_member: {
                    name: {
                        label: string
                        placeholder: string
                    }
                    year: {
                        placeholder: string
                        label: string
                    }
                    profession: {
                        label: string
                        placeholder: string
                    }
                    knows_animals: {
                        label: string
                    }
                    animal: {
                        label: string
                    }
                    type: {
                        label: string
                        placeholder: string
                    }
                    good_with_animals: {
                        label: string
                    }
                    castrated: {
                        label: string
                    }
                }
                garden: {
                    garden: {
                        label: string
                    }
                    garden_size: {
                        placeholder: string
                        label: string
                    }
                    garden_secure: {
                        label: string
                    }
                    garden_connected: {
                        label: string
                    }
                }
                home: {
                    type: {
                        label: string
                        apartment: string
                        house: string
                        other: string
                    }
                    own: {
                        label: string
                    }
                    pets_allowed: {
                        label: string
                        description: string
                    }
                    move_in_date: {
                        label: string
                    }
                    size: {
                        label: string
                        placeholder: string
                    }
                    level: {
                        label: string
                    }
                    location: {
                        label: string
                        city: string
                        suburb: string
                        rural: string
                    }
                }
                experience: {
                    has_animals: string
                    as_string: string
                    dog: string
                    other: string
                    work: string
                    pet: string
                    cat: string
                }
                eligibility: {
                    animal_protection_experience: {
                        label: string
                    }
                    can_afford_insurance: {
                        label: string
                    }
                    can_cover_emergencies: {
                        label: string
                        description: string
                    }
                    can_cover_expenses: {
                        label: string
                        description: string
                    }
                    can_afford_castration: {
                        label: string
                    }
                    substitute: {
                        placeholder: string
                        label: string
                    }
                    time_alone_daily: {
                        label: string
                    }
                }
                specific: {
                    dogs: {
                        select: {
                            label: string
                        }
                        habitat: {
                            label: string
                            options: {
                                home: string
                                garden: string
                                other: string
                            }
                        }
                        purpose: {
                            label: string
                            options: {
                                pet: string
                                work: string
                                other: string
                            }
                        }
                        dog_school: {
                            label: string
                        }
                        time_to_occupy: {
                            label: string
                        }
                    }
                    cats: {
                        select: {
                            label: string
                        }
                        habitat: {
                            label: string
                            options: {
                                indoor: string
                                outdoor: string
                                both: string
                            }
                        }
                        sleeping_place: {
                            label: string
                            placeholder: string
                        }
                        streets_safe: {
                            label: string
                        }
                        flap_available: {
                            label: string
                        }
                        house_secure: {
                            label: string
                        }
                    }
                }
                confirmation: {
                    everyone_agrees: {
                        label: string
                    }
                    not_banned: {
                        label: string
                    }
                    accepted_inaccuracy: {
                        label: string
                    }
                    has_proof_of_identity: {
                        label: string
                    }
                    notes: {
                        label: string
                    }
                }
            }
            complete: {
                thank_you: string
                changes: string
                return_home: string
            }
            cancel_message: string
            close_message: string
        }
        family_members: {
            dog: string
            cat: string
            other: string
            child: string
            adult: string
        }
        button: {
            complete: string
        }
    }
}
