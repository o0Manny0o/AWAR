const Ziggy = {
    url: 'http:\/\/localhost',
    port: null,
    defaults: {},
    routes: {
        'sanctum.csrf-cookie': {
            uri: 'sanctum\/csrf-cookie',
            methods: ['GET', 'HEAD'],
        },
        'stancl.tenancy.asset': {
            uri: 'tenancy\/assets\/{path?}',
            methods: ['GET', 'HEAD'],
            wheres: { path: '(.*)' },
            parameters: ['path'],
        },
        'landing-page': {
            uri: '\/',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
        },
        about: { uri: 'about', methods: ['GET', 'HEAD'], domain: 'awar.test' },
        pricing: {
            uri: 'pricing',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
        },
        dashboard: {
            uri: 'dashboard',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
        },
        'organisations.applications.create.step': {
            uri: 'organisations\/applications\/create\/{application}\/{step}',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
            parameters: ['application', 'step'],
        },
        'organisations.applications.store.step': {
            uri: 'organisations\/applications\/{application}\/{step}',
            methods: ['POST'],
            domain: 'awar.test',
            parameters: ['application', 'step'],
        },
        'organisations.applications.restore': {
            uri: 'organisations\/applications\/{application}\/restore',
            methods: ['PATCH'],
            domain: 'awar.test',
            parameters: ['application'],
        },
        'organisations.applications.submit': {
            uri: 'organisations\/applications\/{application}\/submit',
            methods: ['PATCH'],
            domain: 'awar.test',
            parameters: ['application'],
        },
        'organisations.applications.index': {
            uri: 'organisations\/applications',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
        },
        'organisations.applications.create': {
            uri: 'organisations\/applications\/create',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
        },
        'organisations.applications.store': {
            uri: 'organisations\/applications',
            methods: ['POST'],
            domain: 'awar.test',
        },
        'organisations.applications.show': {
            uri: 'organisations\/applications\/{application}',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
            parameters: ['application'],
        },
        'organisations.applications.edit': {
            uri: 'organisations\/applications\/{application}\/edit',
            methods: ['GET', 'HEAD'],
            domain: 'awar.test',
            parameters: ['application'],
        },
        'organisations.applications.update': {
            uri: 'organisations\/applications\/{application}',
            methods: ['PUT', 'PATCH'],
            domain: 'awar.test',
            parameters: ['application'],
        },
        'organisations.applications.destroy': {
            uri: 'organisations\/applications\/{application}',
            methods: ['DELETE'],
            domain: 'awar.test',
            parameters: ['application'],
        },
        'tenant.landing-page': { uri: '\/', methods: ['GET', 'HEAD'] },
        'organisation.invitations.accept': {
            uri: 'invitations\/accept\/{token}',
            methods: ['GET', 'HEAD'],
            parameters: ['token'],
        },
        'tenant.dashboard': { uri: 'dashboard', methods: ['GET', 'HEAD'] },
        'organisation.invitations.resend': {
            uri: 'invitations\/resend\/{id}',
            methods: ['POST'],
            parameters: ['id'],
        },
        'organisation.invitations.index': {
            uri: 'invitations',
            methods: ['GET', 'HEAD'],
        },
        'organisation.invitations.create': {
            uri: 'invitations\/create',
            methods: ['GET', 'HEAD'],
        },
        'organisation.invitations.store': {
            uri: 'invitations',
            methods: ['POST'],
        },
        'organisation.invitations.show': {
            uri: 'invitations\/{invitation}',
            methods: ['GET', 'HEAD'],
            parameters: ['invitation'],
        },
        'organisation.members.index': {
            uri: 'members',
            methods: ['GET', 'HEAD'],
        },
        'animals.dogs.index': {
            uri: 'animals\/dogs',
            methods: ['GET', 'HEAD'],
        },
        'animals.dogs.create': {
            uri: 'animals\/dogs\/create',
            methods: ['GET', 'HEAD'],
        },
        'animals.dogs.store': { uri: 'animals\/dogs', methods: ['POST'] },
        'animals.dogs.show': {
            uri: 'animals\/dogs\/{animal}',
            methods: ['GET', 'HEAD'],
            parameters: ['animal'],
        },
        'animals.dogs.edit': {
            uri: 'animals\/dogs\/{animal}\/edit',
            methods: ['GET', 'HEAD'],
            parameters: ['animal'],
        },
        'animals.dogs.update': {
            uri: 'animals\/dogs\/{animal}',
            methods: ['PUT', 'PATCH'],
            parameters: ['animal'],
        },
        'animals.dogs.destroy': {
            uri: 'animals\/dogs\/{animal}',
            methods: ['DELETE'],
            parameters: ['animal'],
        },
        'animals.cats.index': {
            uri: 'animals\/cats',
            methods: ['GET', 'HEAD'],
        },
        'animals.cats.create': {
            uri: 'animals\/cats\/create',
            methods: ['GET', 'HEAD'],
        },
        'animals.cats.store': { uri: 'animals\/cats', methods: ['POST'] },
        'animals.cats.show': {
            uri: 'animals\/cats\/{animal}',
            methods: ['GET', 'HEAD'],
            parameters: ['animal'],
        },
        'animals.cats.edit': {
            uri: 'animals\/cats\/{animal}\/edit',
            methods: ['GET', 'HEAD'],
            parameters: ['animal'],
        },
        'animals.cats.update': {
            uri: 'animals\/cats\/{animal}',
            methods: ['PUT', 'PATCH'],
            parameters: ['animal'],
        },
        'animals.cats.destroy': {
            uri: 'animals\/cats\/{animal}',
            methods: ['DELETE'],
            parameters: ['animal'],
        },
        'profile.edit': { uri: 'profile', methods: ['GET', 'HEAD'] },
        'profile.update': { uri: 'profile', methods: ['PATCH'] },
        'profile.destroy': { uri: 'profile', methods: ['DELETE'] },
        language: {
            uri: 'language\/{language}',
            methods: ['GET', 'HEAD'],
            parameters: ['language'],
        },
        register: { uri: 'register', methods: ['GET', 'HEAD'] },
        login: { uri: 'login', methods: ['GET', 'HEAD'] },
        'password.request': {
            uri: 'forgot-password',
            methods: ['GET', 'HEAD'],
        },
        'password.email': { uri: 'forgot-password', methods: ['POST'] },
        'password.reset': {
            uri: 'reset-password\/{token}',
            methods: ['GET', 'HEAD'],
            parameters: ['token'],
        },
        'password.store': { uri: 'reset-password', methods: ['POST'] },
        'verification.notice': {
            uri: 'verify-email',
            methods: ['GET', 'HEAD'],
        },
        'verification.verify': {
            uri: 'verify-email\/{id}\/{hash}',
            methods: ['GET', 'HEAD'],
            parameters: ['id', 'hash'],
        },
        'verification.send': {
            uri: 'email\/verification-notification',
            methods: ['POST'],
        },
        'password.confirm': {
            uri: 'confirm-password',
            methods: ['GET', 'HEAD'],
        },
        'password.update': { uri: 'password', methods: ['PUT'] },
        logout: { uri: 'logout', methods: ['POST'] },
        'storage.local': {
            uri: 'storage\/{path}',
            methods: ['GET', 'HEAD'],
            wheres: { path: '.*' },
            parameters: ['path'],
        },
    },
}
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes)
}
export { Ziggy }
