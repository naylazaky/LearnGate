<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        Content::create([
            'course_id' => 1,
            'title' => 'Introduction to Basic Grammar',
            'description' => 'Learn the fundamentals of English grammar including tenses and sentence structure',
            'content_type' => 'text',
            'content_text' => "Welcome to English Grammar Basics!\n\nIn this lesson, you will learn:\n- Parts of speech (nouns, verbs, adjectives, etc.)\n- Basic sentence structure\n- Present, past, and future tenses\n- Common grammar mistakes to avoid\n\nGrammar is the foundation of effective communication in English. Understanding these basics will help you speak and write more confidently.",
            'order' => 1,
        ]);
        
        Content::create([
            'course_id' => 1,
            'title' => 'Simple Present Tense',
            'description' => 'Master the simple present tense for daily routines and facts',
            'content_type' => 'text',
            'content_text' => "Simple Present Tense\n\nUsed for:\n- Habits and routines: I wake up at 7am every day\n- Facts and general truths: The sun rises in the east\n- Permanent situations: She works in a hospital\n\nFormation:\nPositive: Subject + base verb (add -s/-es for he/she/it)\nNegative: Subject + do/does not + base verb\nQuestion: Do/Does + subject + base verb?\n\nExamples:\n✓ I study English every day\n✓ She doesn't like coffee\n✓ Do you speak English?",
            'order' => 2,
        ]);

        Content::create([
            'course_id' => 1,
            'title' => 'Past Simple Tense',
            'description' => 'Learn how to talk about completed actions in the past',
            'content_type' => 'text',
            'content_text' => "Past Simple Tense\n\nUsed for:\n- Completed actions in the past\n- Past habits\n- Series of completed actions\n\nFormation:\nRegular verbs: base verb + -ed (walked, played, studied)\nIrregular verbs: special forms (went, ate, bought)\n\nExamples:\n✓ I visited London last year\n✓ She didn't go to the party\n✓ Did you finish your homework?\n\nCommon irregular verbs:\ngo → went, eat → ate, see → saw, take → took",
            'order' => 3,
        ]);

        Content::create([
            'course_id' => 2,
            'title' => 'Greetings and Introductions',
            'description' => 'Learn how to greet people and introduce yourself in English',
            'content_type' => 'text',
            'content_text' => "Greetings and Introductions\n\nCommon Greetings:\n- Hello! / Hi!\n- Good morning/afternoon/evening\n- How are you? / How's it going?\n- Nice to meet you!\n\nIntroducing Yourself:\n- My name is...\n- I'm from...\n- I work as a... / I'm a student\n- It's nice to meet you!\n\nSample Dialogue:\nA: Hi! I'm Sarah. Nice to meet you.\nB: Hello Sarah! I'm Tom. Nice to meet you too!\nA: Where are you from, Tom?\nB: I'm from Indonesia. How about you?\nA: I'm from Australia.",
            'order' => 1,
        ]);

        Content::create([
            'course_id' => 2,
            'title' => 'Daily Conversations',
            'description' => 'Practice common phrases for everyday situations',
            'content_type' => 'text',
            'content_text' => "Daily Conversation Topics\n\n1. Talking about the Weather:\n- It's a beautiful day today!\n- It's quite cold, isn't it?\n- I love this sunny weather\n\n2. Making Plans:\n- What are you doing this weekend?\n- Would you like to grab coffee sometime?\n- I'm planning to visit the museum\n\n3. Discussing Hobbies:\n- What do you like to do in your free time?\n- I enjoy reading and playing sports\n- Have you tried cooking?\n\n4. At Work/School:\n- How's work/school going?\n- I have a meeting at 2pm\n- The deadline is tomorrow",
            'order' => 2,
        ]);

        Content::create([
            'course_id' => 3,
            'title' => 'Essential Vocabulary - Daily Life',
            'description' => 'Learn the most common English words for everyday situations',
            'content_type' => 'text',
            'content_text' => "Daily Life Vocabulary\n\nAt Home:\n- Rooms: bedroom, kitchen, bathroom, living room\n- Furniture: sofa, table, chair, bed, desk\n- Appliances: refrigerator, oven, washing machine, TV\n\nFood & Drinks:\n- Meals: breakfast, lunch, dinner, snack\n- Fruits: apple, banana, orange, grape, strawberry\n- Vegetables: carrot, tomato, potato, lettuce, onion\n- Drinks: water, tea, coffee, juice, milk\n\nTime Expressions:\n- morning, afternoon, evening, night\n- yesterday, today, tomorrow\n- last week, this month, next year\n\nPractice: Use these words to describe your daily routine!",
            'order' => 1,
        ]);
        
        Content::create([
            'course_id' => 3,
            'title' => 'Common English Idioms',
            'description' => 'Understand and use popular English idioms in conversation',
            'content_type' => 'text',
            'content_text' => "Common English Idioms\n\n1. Break the ice\n   Meaning: Make people feel more comfortable in social situations\n   Example: Let's play a game to break the ice at the party\n\n2. Piece of cake\n   Meaning: Something very easy to do\n   Example: The English test was a piece of cake!\n\n3. Under the weather\n   Meaning: Feeling sick or ill\n   Example: I'm feeling a bit under the weather today\n\n4. Hit the books\n   Meaning: To study hard\n   Example: I need to hit the books before my exam tomorrow\n\n5. Cost an arm and a leg\n   Meaning: Very expensive\n   Example: That new iPhone costs an arm and a leg!\n\n6. Once in a blue moon\n   Meaning: Very rarely\n   Example: I only eat fast food once in a blue moon\n\nTry using these idioms in your daily conversations!",
            'order' => 2,
        ]);
    }
}