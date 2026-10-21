# Ashenreach Game Rules Summary

Ashenreach is a persistent medieval fantasy kingdom text browser game (Torn-style) where players spend regenerating bars on actions, earn gold and materials, and reinvest in gear, skills, and guild activity.

## Core Rules
1. **Server-Side Authority:** All game rules, dice rolls, and randomness run on the server.
2. **Atomic Updates:** Financial and item transactions use atomic conditional updates (`WHERE gold >= ?`) to guarantee data integrity under SQLite.
3. **Unsigned Integers:** Gold is stored as unsigned integers. No floats.
4. **Regenerating Bars:** Stamina, Courage, and Focus regenerate over time based on timestamps rather than background tasks.
5. **Dice System:** All checks use a d20 + stat modifier + skill bonus vs a Difficulty Class (DC). Natural 20 is a critical success; Natural 1 is a critical failure.
