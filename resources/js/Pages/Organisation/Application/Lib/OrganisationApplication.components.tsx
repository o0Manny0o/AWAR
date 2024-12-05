import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { SwitchInput } from '@/Components/_Base/Input'
import { useContext } from 'react'
import {
    removeTrailingDash,
    transformSubdomain,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.util'
import ShowGroup from '@/Components/_Base/Input/ShowGroup'
import { usePage } from '@inertiajs/react'
import { ApplicationFormWrapper } from '@/Pages/Organisation/Application/Lib/OrganisationApplication.context'
import OrganisationApplication = App.Models.OrganisationApplication

interface GroupProps {
    setData: (key: string, value: any) => void
}

interface GeneralInfoGroupProps extends GroupProps {
    data: {
        name: string
        type: string
        user_role: string
        registered: boolean
    }
    errors: {
        name?: string
        type?: string
        user_role?: string
        registered?: string
    }
}

export function GeneralInfoGroup({
    data,
    errors,
    setData,
}: GeneralInfoGroupProps) {
    const __ = useTranslate()

    const {
        refs: { name, type, role, registered },
    } = useContext(ApplicationFormWrapper.Context)

    return (
        <>
            <InputGroup
                name="name"
                placeholder={__(
                    'organisations.applications.form.name.placeholder',
                )}
                value={data.name}
                ref={name}
                label={__('organisations.applications.form.name.label')}
                error={errors.name}
                onChange={(value) => setData('name', value)}
            />

            <InputGroup
                name="type"
                placeholder={__(
                    'organisations.applications.form.type.placeholder',
                )}
                value={data.type}
                ref={type}
                label={__('organisations.applications.form.type.label')}
                error={errors.type}
                onChange={(value) => setData('type', value)}
            />

            <InputGroup
                name="role"
                placeholder={__(
                    'organisations.applications.form.user_role.placeholder',
                )}
                value={data.user_role}
                ref={role}
                label={__('organisations.applications.form.user_role.label')}
                error={errors.user_role}
                onChange={(value) => setData('user_role', value)}
            />

            <SwitchInput
                name={'registered'}
                checked={data.registered}
                ref={registered}
                label={'Are you officially registered?'}
                error={errors.registered}
                onChange={(value) => setData('registered', value)}
            />
        </>
    )
}

interface AddressInfoGroupProps extends GroupProps {
    data: {
        street: string
        post_code: string
        city: string
        country: string
    }
    errors: {
        street?: string
        post_code?: string
        city?: string
        country?: string
    }
}

export function AddressInfoGroup({
    data,
    errors,
    setData,
}: AddressInfoGroupProps) {
    const __ = useTranslate()

    const {
        refs: { street, postCode, city, country },
    } = useContext(ApplicationFormWrapper.Context)

    return (
        <>
            <InputGroup
                name="name"
                placeholder={__(
                    'organisations.applications.form.street.placeholder',
                )}
                value={data.street}
                ref={street}
                label={__('organisations.applications.form.street.label')}
                error={errors.street}
                onChange={(value) => setData('street', value)}
            />

            <InputGroup
                name="postCode"
                placeholder={__(
                    'organisations.applications.form.post_code.placeholder',
                )}
                value={data.post_code}
                ref={postCode}
                label={__('organisations.applications.form.post_code.label')}
                error={errors.post_code}
                onChange={(value) => setData('post_code', value)}
            />

            <InputGroup
                name="city"
                placeholder={__(
                    'organisations.applications.form.city.placeholder',
                )}
                value={data.city}
                ref={city}
                label={__('organisations.applications.form.city.label')}
                error={errors.city}
                onChange={(value) => setData('city', value)}
            />

            <InputGroup
                name="country"
                placeholder={__(
                    'organisations.applications.form.country.placeholder',
                )}
                value={data.country}
                ref={country}
                label={__('organisations.applications.form.country.label')}
                error={errors.country}
                onChange={(value) => setData('country', value)}
            />
        </>
    )
}

interface SubdomainInfoGroupProps extends GroupProps {
    domain: string
    data: {
        subdomain: string
    }
    errors: {
        subdomain?: string
    }
}

export function SubdomainInfoGroup({
    data,
    errors,
    setData,
}: SubdomainInfoGroupProps) {
    const __ = useTranslate()

    const { centralDomain } = usePage().props
    const {
        refs: { subdomain },
    } = useContext(ApplicationFormWrapper.Context)

    return (
        <>
            <InputGroup
                name="subdomain"
                value={data.subdomain}
                ref={subdomain}
                label={__('organisations.applications.form.subdomain.label')}
                placeholder={__(
                    'organisations.applications.form.subdomain.placeholder',
                )}
                error={errors.subdomain}
                onChange={(value) =>
                    setData('subdomain', transformSubdomain(value))
                }
                onBlur={() =>
                    setData('subdomain', removeTrailingDash(data.subdomain))
                }
                leading={'https://'}
                append={`.${centralDomain}`}
                className="pl-16"
            />
        </>
    )
}

export function GeneralInfoShowGroup({
    application,
}: {
    application: OrganisationApplication
}) {
    const __ = useTranslate()
    return (
        <>
            <ShowGroup
                name="name"
                label={__('organisations.applications.form.name.label')}
                value={application.name}
            />
            <ShowGroup
                name="type"
                label={__('organisations.applications.form.type.label')}
                value={application.type}
            />
            <ShowGroup
                name="role"
                label={__('organisations.applications.form.user_role.label')}
                value={application.user_role}
            />
            <ShowGroup
                name="registered"
                label={__('organisations.applications.form.registered.label')}
                value={String(application.registered)}
            />
        </>
    )
}

export function AddressInfoShowGroup({
    application,
}: {
    application: OrganisationApplication
}) {
    const __ = useTranslate()
    return (
        <>
            <ShowGroup
                name="street"
                label={__('organisations.applications.form.street.label')}
                value={application.street}
            />
            <ShowGroup
                name="post_code"
                label={__('organisations.applications.form.post_code.label')}
                value={application.post_code}
            />
            <ShowGroup
                name="city"
                label={__('organisations.applications.form.city.label')}
                value={application.city}
            />
            <ShowGroup
                name="country"
                label={__('organisations.applications.form.country.label')}
                value={application.country}
            />
        </>
    )
}

export function SubdomainInfoShowGroup({
    application,
}: {
    application: OrganisationApplication
}) {
    const __ = useTranslate()
    const { centralDomain } = usePage().props
    return (
        <>
            <ShowGroup
                leading={'https://'}
                append={`.${centralDomain}`}
                name="subdomain"
                label={__('organisations.applications.form.subdomain.label')}
                value={application.subdomain}
            />
        </>
    )
}
