import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

type GeneralInfoRefContextData = {
    name: RefObject<HTMLInputElement>
    type: RefObject<HTMLInputElement>
    role: RefObject<HTMLInputElement>
    registered: RefObject<HTMLButtonElement>
}
type AddressRefContextData = {
    street: RefObject<HTMLInputElement>
    postCode: RefObject<HTMLInputElement>
    city: RefObject<HTMLInputElement>
    country: RefObject<HTMLInputElement>
}
type SubdomainRefContextData = {
    subdomain: RefObject<HTMLInputElement>
}

type EditRefContextData = GeneralInfoRefContextData &
    AddressRefContextData &
    SubdomainRefContextData

export const ApplicationFormWrapper = FormContext<EditRefContextData>([
    'name',
    'type',
    'role',
    'registered',
    'street',
    'postCode',
    'city',
    'country',
    'subdomain',
])
