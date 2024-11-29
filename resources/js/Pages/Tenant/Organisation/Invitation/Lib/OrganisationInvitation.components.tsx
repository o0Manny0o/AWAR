import InputGroup from '@/Components/_Base/Input/InputGroup'
import useTranslate from '@/shared/hooks/useTranslate'
import { SwitchInput } from '@/Components/_Base/Input'
import { useContext } from 'react'
import { FormInputRefs } from '@/Pages/Tenant/Organisation/Invitation/Lib/OrganisationInvitation.context'

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
}

export function CreateGroup({ data, errors, setData }: CreateGroupProps) {
    const __ = useTranslate()

    const {
        refs: { email, role },
    } = useContext(FormInputRefs.Context)

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

            <InputGroup
                name="role"
                type="text"
                placeholder={__(
                    'organisations.invitations.form.role.placeholder',
                )}
                value={data.role}
                ref={role}
                label={__('organisations.invitations.form.role.label')}
                error={errors.role}
                onChange={(value) => setData('role', value)}
            />
        </>
    )
}
