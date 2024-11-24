import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { SwitchInput } from '@/Components/_Base/Input'
import { useContext } from 'react'
import {
    removeTrailingDash,
    transformSubdomain,
} from '@/Pages/Organisation/Application/Lib/OrganisationApplication.util'
import { InputFocusContext } from '@/Pages/Organisation/Application/Lib/OrganisationApplicationInputContext'

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

    const { nameRef, typeRef, roleRef, registeredRef } =
        useContext(InputFocusContext)

    return (
        <>
            <InputGroup
                name="name"
                placeholder={__(
                    'organisations.applications.form.name.placeholder',
                )}
                value={data.name}
                ref={nameRef}
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
                ref={typeRef}
                label={__('organisations.applications.form.type.label')}
                error={errors.type}
                onChange={(value) => setData('type', value)}
            />

            <InputGroup
                name="role"
                placeholder={__(
                    'organisations.applications.form.role.placeholder',
                )}
                value={data.user_role}
                ref={roleRef}
                label={__('organisations.applications.form.role.label')}
                error={errors.user_role}
                onChange={(value) => setData('user_role', value)}
            />

            <SwitchInput
                name={'registered'}
                checked={data.registered}
                ref={registeredRef}
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

    const { streetRef, postCodeRef, cityRef, countryRef } =
        useContext(InputFocusContext)

    return (
        <>
            <InputGroup
                name="name"
                placeholder={__(
                    'organisations.applications.form.street.placeholder',
                )}
                value={data.street}
                ref={streetRef}
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
                ref={postCodeRef}
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
                ref={cityRef}
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
                ref={countryRef}
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
    domain,
    data,
    errors,
    setData,
}: SubdomainInfoGroupProps) {
    const __ = useTranslate()

    const { subdomainRef } = useContext(InputFocusContext)

    return (
        <>
            <InputGroup
                name="subdomain"
                value={data.subdomain}
                ref={subdomainRef}
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
                append={`.${domain}`}
                className="pl-16"
            />
        </>
    )
}
