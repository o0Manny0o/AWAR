type Translations = {
    auth: Translations_Auth
    pagination: Translations_Pagination
    passwords: Translations_Passwords
    validation: Translations_Validation
    general: Translations_General
    landing_page: Translations_Landing_page
    organisations: Translations_Organisations
    animals: Translations_Animals
    history: Translations_History
    countries: Translations_Countries
}
type Translations_Auth = {
    failed: string
    password: string
    throttle: string
}
type Translations_Pagination = {
    previous: string
    next: string
}
type Translations_Passwords = {
    reset: string
    sent: string
    throttled: string
    token: string
    user: string
}
type Translations_Validation = {
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
    between: Validation_Set
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
    gt: Validation_Set
    gte: Validation_Set
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
    lt: Validation_Set
    lte: Validation_Set
    mac_address: string
    max: Validation_Set
    max_digits: string
    mimes: string
    mimetypes: string
    min: Validation_Set
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
    password: Validation_Password
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
    size: Validation_Set
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
type Validation_Set = {
    array: string
    file: string
    numeric: string
    string: string
}
type Validation_Password = {
    letters: string
    mixed: string
    numbers: string
    symbols: string
    uncompromised: string
}
type Translations_General = {
    languages: General_Languages
    navigation: General_Navigation
    newsletter: General_Newsletter
    legal: General_Legal
    layout: General_Layout
    status: General_Status
    button: General_Button
    last_update: string
    options: string
    deleted: string
    your_resource: string
    continue_later: string
    resources: General_Resources
    roles: General_Roles
    images: string
}
type General_Languages = {
    en: string
    de: string
}
type General_Navigation = {
    register: string
    dashboard: string
    login: string
    logout: string
    profile: string
    about: string
    home: string
    organisations: Navigation_Organisations
    overview: string
    your_organisations: string
    your_dashboard: string
    animals: Navigation_Animals
    browse: string
    pricing: string
}
type Navigation_Organisations = {
    applications: string
    invitations: string
    members: string
    locations: string
}
type Navigation_Animals = {
    dogs: string
    cats: string
}
type General_Newsletter = {
    description: string
    heading: string
    subscribe: string
}
type General_Legal = {
    rights_reserved: string
}
type General_Layout = {
    open_user_menu: string
    open_sidebar: string
    close_sidebar: string
}
type General_Status = {
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
type General_Button = {
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
}
type General_Resources = {
    organisation: Resources_Organisation
    animals: Resources_Animals
}
type Resources_Organisation = {
    invitation: string
    application: string
    location: string
}
type Resources_Animals = {
    dog: string
    cat: string
}
type General_Roles = {
    tenant: Roles_Tenant
}
type Roles_Tenant = {
    admin: string
    member: string
    adoption_lead: string
    adoption_handler: string
    foster_home_lead: string
    foster_home_handler: string
    foster_home: string
}
type Translations_Landing_page = {
    welcome_message: string
}
type Translations_Organisations = {
    applications: Organisations_Applications
    invitations: Organisations_Invitations
    members: Organisations_Members
    dashboard: Organisations_Dashboard
    locations: Organisations_Locations
}
type Organisations_Applications = {
    form: Applications_Form
}
type Applications_Form = {
    name: Form_Set
    type: Form_Set
    registered: RegisteredOrToken
    street: Form_Set
    post_code: Form_Set
    city: Form_Set
    country: Form_Set
    general_info: string
    subdomain: Form_Set
    address_info: string
    subdomain_info: string
    cancel_create: string
    user_role: Form_Set
}
type Form_Set = {
    label: string
    placeholder: string
}
type RegisteredOrToken = {
    label: string
}
type Organisations_Invitations = {
    mail: Invitations_Mail
    form: Invitations_Form
    titles: Invitations_Set
    headers: Invitations_Set
    messages: Invitations_Messages
}
type Invitations_Mail = {
    header: string
    body: string
    get_started: string
    regards: string
    subject: string
}
type Invitations_Form = {
    email: Form_Set
    role: Form_Set
    token: RegisteredOrToken
    cancel_create: string
}
type Invitations_Set = {
    create: string
    index: string
}
type Invitations_Messages = {
    sent: string
    expired: string
    accepted: string
    already_accepted: string
    wrong_email: string
}
type Organisations_Members = {
    headers: HeadersOrTitles
    titles: HeadersOrTitles
}
type HeadersOrTitles = {
    index: string
}
type Organisations_Dashboard = {
    welcome: string
}
type Organisations_Locations = {
    headers: Invitations_Set
    titles: Invitations_Set
    form: Locations_Form
}
type Locations_Form = {
    cancel_create: string
}
type Translations_Animals = {
    dogs: Animals_Dogs
    cats: Animals_Cats
    form_general: Animals_Form_general
}
type Animals_Dogs = {
    headers: Invitations_Set
    titles: Titles
    form: Form
}
type Titles = {
    index: string
    create: string
    edit: string
}
type Form = {
    name: Form_Set
    breed: Form_Set
    date_of_birth: Form_Set
    bio: Form_Set
    abstract: Form_Set
    family: Family
}
type Family = {
    header: string
}
type Animals_Cats = {
    titles: Titles
    headers: Invitations_Set
    form: Form
}
type Animals_Form_general = {
    family: Form_Set
}
type Translations_History = {
    changes: History_Changes
    title: string
}
type History_Changes = {
    internal: Changes_Internal
    public: Changes_Public
}
type Changes_Internal = {
    initial: string
    update: string
    delete: string
    restore: string
    publish: string
    unpublish: string
}
type Changes_Public = {
    initial: string
}
type Translations_Countries = {
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
