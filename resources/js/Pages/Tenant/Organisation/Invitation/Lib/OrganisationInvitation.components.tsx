import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate, { toTranslationKey } from '@/shared/hooks/useTranslate'
import { useContext } from 'react'
import { FormInputRefs } from '@/Pages/Tenant/Organisation/Invitation/Lib/OrganisationInvitation.context'
import SelectGroup from '@/Components/_Base/Input/SelectGroup'

interface GroupProps {
    setData: (key: string, value: any) => void
}

interface CreateGroupProps extends GroupProps {
    data: {
        email: string
        role: string
    }
    errors: {
        email?: string
        role?: string
    }
    readonly roleOptions: string[]
}

export function CreateGroup({
    data,
    errors,
    setData,
    roleOptions,
}: CreateGroupProps) {
    const __ = useTranslate()

    const {
        refs: { email, role },
    } = useContext(FormInputRefs.Context)

    const roleBase: TranslationKey = 'general.roles.tenant'

    return (
        <>
            <InputGroup
                name="email"
                type="email"
                placeholder={__(
                    'organisations.invitations.form.email.placeholder',
                )}
                value={data.email}
                ref={email}
                label={__('organisations.invitations.form.email.label')}
                error={errors.email}
                onChange={(value) => setData('email', value)}
            />

            <SelectGroup
                name="role"
                value={data.role}
                ref={role}
                label={__('organisations.invitations.form.role.label')}
                error={errors.role}
                onChange={(event) => setData('role', event.target.value)}
                options={roleOptions.map((role) => ({
                    value: role,
                    label: __(toTranslationKey(`${roleBase}.${role}`)),
                }))}
            />
        </>
    )
}
