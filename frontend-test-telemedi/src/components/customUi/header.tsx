import { Outlet } from 'react-router-dom'
import { Flex, Link as ChakraLink, Box } from '@chakra-ui/react'
import {NavLink} from "./navLink";

export const Header = () => {
    return (
        <Box>
            <Flex as="nav" bg="orange.600" color="white">
                {[
                    { to: '/employees', label: 'Employees' },
                    { to: '/shift', label: 'Shifts' },
                    { to: '/predictions', label: 'Predictions' },
                ].map(({ to, label }) => (
                    <NavLink
                        key={to}
                        w='150px'
                        to={to}
                        px={5}
                        py={4}
                        m={0}
                        color='white'
                        borderRight='3px solid black'
                        position="relative"
                        _hover={{ textDecoration: 'none', bg: 'orange.400' }}
                        isActiveStyles={{
                            fontWeight: 'bold',
                            bg: 'orange.700',
                        }}
                    >
                        {label}
                    </NavLink>
                ))}
            </Flex>

            <Box p="4">
                <Outlet />
            </Box>
        </Box>
    )
}
