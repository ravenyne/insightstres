import pandas as pd

print("=== LOADING RAW DATASET ===")
df = pd.read_csv("../dataset/Stress_Dataset.csv")

# ================================
# 1. CLEAN COLUMN NAMES
# ================================
df.columns = (
    df.columns.str.replace("?", "", regex=False)
              .str.replace(".", "_", regex=False)
              .str.replace(" ", "_")
              .str.lower()
              .str.strip()
)

# RENAME col for consistency
df = df.rename(columns={
    "have_you_been_dealing_with_anxiety_or_tension_recently_1": 
        "have_you_been_dealing_with_anxiety_or_tension_recently_1",
    "have_you_gained_lost_weight": "weight_change",
    "which_type_of_stress_do_you_primarily_experience": "stress_type"
})

# ================================
# 2. CLEAN LABELS
# ================================
def simplify_label(text):
    text = text.lower()

    if "no stress" in text:
        return "No Stress"
    if "eustress" in text:
        return "Eustress"
    if "distress" in text:
        return "Distress"

    return "Other"

df["stress_type"] = df["stress_type"].apply(simplify_label)

# ================================
# 3. MAP LABEL → INTEGER
# ================================
label_map = {
    "No Stress": 0,
    "Eustress": 1,
    "Distress": 2,
    "Other": 3
}

df["label"] = df["stress_type"].map(label_map)

# ================================
# 4. DEFINE FEATURES
# ================================
features = [
    "gender","age",
    "have_you_recently_experienced_stress_in_your_life",
    "have_you_noticed_a_rapid_heartbeat_or_palpitations",
    "have_you_been_dealing_with_anxiety_or_tension_recently",
    "do_you_face_any_sleep_problems_or_difficulties_falling_asleep",
    "have_you_been_dealing_with_anxiety_or_tension_recently_1",
    "have_you_been_getting_headaches_more_often_than_usual",
    "do_you_get_irritated_easily",
    "do_you_have_trouble_concentrating_on_your_academic_tasks",
    "have_you_been_feeling_sadness_or_low_mood",
    "have_you_been_experiencing_any_illness_or_health_issues",
    "do_you_often_feel_lonely_or_isolated",
    "do_you_feel_overwhelmed_with_your_academic_workload",
    "are_you_in_competition_with_your_peers,_and_does_it_affect_you",
    "do_you_find_that_your_relationship_often_causes_you_stress",
    "are_you_facing_any_difficulties_with_your_professors_or_instructors",
    "is_your_working_environment_unpleasant_or_stressful",
    "do_you_struggle_to_find_time_for_relaxation_and_leisure_activities",
    "is_your_hostel_or_home_environment_causing_you_difficulties",
    "do_you_lack_confidence_in_your_academic_performance",
    "do_you_lack_confidence_in_your_choice_of_academic_subjects",
    "academic_and_extracurricular_activities_conflicting_for_you",
    "do_you_attend_classes_regularly",
    "weight_change"
]

df_final = df[features + ["label"]]

# ================================
# 5. SAVE CLEAN DATASET
# ================================
df_final.to_csv("../dataset/stress_clean_classifier.csv", index=False)

print("=== CLEAN CLASSIFIER DATASET SAVED ===")
print(df_final.head())