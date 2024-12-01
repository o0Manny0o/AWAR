type Translations = {
    auth: Translations_Auth
    pagination: Translations_Pagination
    passwords: Translations_Passwords
    validation: Translations_Validation
    general: Translations_General
    landing_page: Translations_Landing_page
    organisations: Translations_Organisations
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
}
type Navigation_Organisations = {
    applications: string
    invitations: string
    members: string
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
}
type General_Resources = {
    organisation: Resources_Organisation
}
type Resources_Organisation = {
    invitation: string
    application: string
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
    titles: TitlesOrHeaders
    headers: TitlesOrHeaders
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
type TitlesOrHeaders = {
    create: string
    index: string
}
type Organisations_Members = {
    headers: Members_Headers
}
type Members_Headers = {
    index: string
}
type Organisations_Dashboard = {
    welcome: string
}
