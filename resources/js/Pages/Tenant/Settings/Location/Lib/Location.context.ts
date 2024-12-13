import { RefObject } from 'react'
import { FormContext } from '@/shared/contexts/Form.context'

export type LocationFormContextData = {
    name: RefObject<HTMLInputElement>
    publicInput: RefObject<HTMLInputElement>

    street_address: RefObject<HTMLInputElement>
    locality: RefObject<HTMLInputElement>
    region: RefObject<HTMLInputElement>
    postal_code: RefObject<HTMLInputElement>
    country: RefObject<HTMLInputElement>
}

export const LocationFormWrapper = FormContext<LocationFormContextData>([
    'name',
    'publicInput',
    'street_address',
    'locality',
    'region',
    'postal_code',
    'country',
])
