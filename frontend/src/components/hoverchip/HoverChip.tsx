import React from 'react';
import { Chip } from '@mui/material';
import './hoverchip.scss';

interface HoverChipProps {
    label: string;
    onClick?: () => void;
}

const HoverChip: React.FC<HoverChipProps> = ({ label, ...props }) => {
    return (
        <>
            <Chip
                className='hover-chip'
                component={'button'}
                label={label}
                variant="outlined"
                color='primary'
                clickable={true}
                {...props}
            ></Chip >
        </>
    );
};

export default HoverChip;
