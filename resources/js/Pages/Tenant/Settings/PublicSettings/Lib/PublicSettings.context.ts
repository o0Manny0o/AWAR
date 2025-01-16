import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

export type OrganisationPublicSettingsFormContextData = {
    name: RefObject<HTMLInputElement>
}

export const OrganisationPublicSettingsFormWrapper =
    FormContext<OrganisationPublicSettingsFormContextData>(['name'])
