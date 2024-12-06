import { RefObject } from 'react'

export type AnimalFormContextData = {
    name: RefObject<HTMLInputElement>
    date_of_birth: RefObject<HTMLInputElement>
    bio: RefObject<HTMLInputElement>
    abstract: RefObject<HTMLInputElement>
}
