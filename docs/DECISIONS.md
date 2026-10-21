# Ashenreach Decisions Log

This document records the design decisions and choices made for Ashenreach, following Section 5 of the game specification.

1. **Database:** SQLite first for local development and simplicity, with architecture designed to allow moving to PostgreSQL later if needed.
2. **Market Tax:** The 5% market sales tax acts as a gold sink and is completely removed from the economy (destroyed) to prevent inflation.
3. **Careers / Territories:** The "Lord" career is defined as a guild officer who manages a territory.
4. **Character Creation Wizard:** 3-step wizard: 1. Ancestry, 2. Class, 3. Attributes (Point-buy).
5. **Racial Perks:** Mapped concretely in configuration files (e.g., Human skill XP multiplier `1.05`, stat modifiers, etc.).
6. **Formulas:**
   - **XP per level:** `PreviousLevelXP * 1.2` (Level 1 requires 100 XP).
   - **Respec cost:** `Character Level * 100` gold.
   - **Repair cost:** `Item Level * Durability Lost * 5` gold.
7. **Starting Content:** Seeders will include 3 zones, 20 starter items, 4 core skills, and 6 recipes.
8. **Health & Regeneration:** Health equals `20 + (CON modifier * 5)`, regenerating 1% per minute.
9. **Stat Ranges:** Stats cap at 20. Modifiers use `floor((stat - 10) / 2)` and support up to +5.
10. **Admin & Backups:** Minimal admin panel via Filament and daily database backups before public playtesting.
