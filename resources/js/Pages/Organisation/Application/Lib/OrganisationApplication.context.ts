import { RefObject } from 'react'
import { ElementRefContext } from '@/shared/contexts/ElementRef.context'

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

export const FormInputRefs = ElementRefContext<EditRefContextData>([
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
