import { Menu, MenuButton, MenuItem } from '@headlessui/react'
import { EllipsisVerticalIcon } from '@heroicons/react/24/solid'
import useTranslate from '@/shared/hooks/useTranslate'
import { usePage } from '@inertiajs/react'
import { MenuItems } from '@/Components/_Base/MenuItems'
import { MenuItemLink } from '@/Components/_Base'
import { Button } from '@/Components/_Base/Button'
import { ReactNode } from 'react'
import usePermission from '@/shared/hooks/usePermission'

export default function List<
    T extends { id: number | string; updated_at: string; [key: string]: any },
>({
    entities,
    title,
    badge,
    subtitle,
    secondarySubtitle,
    resourceLabel = '',
    resourceUrl,
    menuItems,
}: {
    entities: T[]
    title: (e: T) => string
    subtitle: (e: T) => string
    secondarySubtitle?: (e: T) => string
    badge?: (e: T) => ReactNode
    resourceLabel?: TranslationKey | string
    resourceUrl: string
    menuItems?: ((e: T) => ReactNode)[]
}) {
    const __ = useTranslate()
    const { locale } = usePage().props
    const { canDelete, canRestore, canUpdate, canView, canResend } =
        usePermission()

    return (
        <ul role="list" className="divide-y divide-gray-100">
            {entities.map((entity) => (
                <li
                    key={entity.id}
                    className="flex items-center justify-between gap-x-6 py-5"
                >
                    <div className="min-w-0">
                        <div className="flex items-start gap-x-3">
                            <p className="text-md/6 font-semibold text-gray-900 dark:text-gray-100">
                                {title(entity)}
                            </p>
                            {badge && badge(entity)}
                        </div>
                        <div className="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                            <p className="whitespace-nowrap">
                                {subtitle(entity)}
                            </p>
                            <svg
                                viewBox="0 0 2 2"
                                className="size-0.5 fill-current"
                            >
                                <circle r={1} cx={1} cy={1} />
                            </svg>
                            {secondarySubtitle ? (
                                secondarySubtitle(entity)
                            ) : (
                                <>
                                    {__('general.last_update')}
                                    <time
                                        dateTime={new Date(
                                            entity.updated_at,
                                        ).toLocaleString(locale)}
                                    >
                                        {/* TODO: replace with relative date */}
                                        {new Date(
                                            entity.updated_at,
                                        ).toLocaleString(locale)}
                                    </time>
                                </>
                            )}
                        </div>
                    </div>
                    <div className="flex flex-none items-center gap-x-4">
                        {canView(entity) && (
                            <Button
                                color={'secondary'}
                                href={route(resourceUrl + '.show', entity.id)}
                                className="hidden sm:inline-flex"
                            >
                                {__('general.button.view', {
                                    resource: resourceLabel,
                                })}
                                <span className="sr-only">, {entity.name}</span>
                            </Button>
                        )}
                        <Menu
                            as="div"
                            className={
                                'relative flex-none ' +
                                (menuItems?.length ||
                                canUpdate(entity) ||
                                canDelete(entity) ||
                                canRestore(entity) ||
                                canResend(entity)
                                    ? ''
                                    : 'sm:hidden')
                            }
                        >
                            <MenuButton className="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900">
                                <span className="sr-only">
                                    {__('general.button.open', {
                                        resource: 'general.options',
                                    })}
                                </span>
                                <EllipsisVerticalIcon
                                    aria-hidden="true"
                                    className="size-5"
                                />
                            </MenuButton>
                            <MenuItems>
                                {canView(entity) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            className="sm:hidden"
                                            href={route(
                                                resourceUrl + '.show',
                                                entity.id,
                                            )}
                                        >
                                            {__('general.button.view', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {entity.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}
                                {canUpdate(entity) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            href={route(
                                                resourceUrl + '.edit',
                                                entity.id,
                                            )}
                                        >
                                            {__('general.button.edit', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {entity.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}

                                {canDelete(entity) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            method={'delete'}
                                            as={'button'}
                                            href={route(
                                                resourceUrl + '.destroy',
                                                entity.id,
                                            )}
                                        >
                                            {__('general.button.delete', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {entity.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}

                                {canRestore(entity) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            method={'patch'}
                                            as={'button'}
                                            href={route(
                                                resourceUrl + '.restore',
                                                entity.id,
                                            )}
                                        >
                                            {__('general.button.restore', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {entity.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}

                                {canResend(entity) && (
                                    <MenuItem>
                                        <MenuItemLink
                                            method={'post'}
                                            as={'button'}
                                            href={route(
                                                resourceUrl + '.resend',
                                                entity.id,
                                            )}
                                        >
                                            {__('general.button.resend', {
                                                resource: '',
                                            })}
                                            <span className="sr-only">
                                                , {entity.name}
                                            </span>
                                        </MenuItemLink>
                                    </MenuItem>
                                )}

                                {menuItems?.length &&
                                    menuItems.map((item) => item(entity))}
                            </MenuItems>
                        </Menu>
                    </div>
                </li>
            ))}
        </ul>
    )
}
