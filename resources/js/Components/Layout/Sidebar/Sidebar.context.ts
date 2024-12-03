import { createContext } from 'react'

type SidebarContextData = {
    colored?: boolean
}

export const SidebarContext = createContext<SidebarContextData>({})
